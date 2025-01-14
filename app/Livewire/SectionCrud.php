<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CourseSection;
use App\Models\Course;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Program;
use Spatie\Activitylog\Traits\LogsActivity;
use Livewire\WithPagination;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class SectionCrud extends Component
{
    use WithPagination;

    public function render()
    {
        // Paginate CourseSection with filters and search
        $sections = CourseSection::query()
            // Join
            ->leftJoin('courses', 'course_sections.course_id', '=', 'courses.course_id')
            ->leftJoin('programs', 'course_sections.program_id', '=', 'programs.program_id')
            ->leftJoin('faculties', 'course_sections.faculty_id', '=', 'faculties.faculty_id')
            
            // Select specific columns
            ->select(
                'course_sections.*',
                'courses.course_name as course_name',
                'programs.program_name as program_name',
                DB::raw("CONCAT(faculties.first_name, ' ', faculties.last_name) as faculty_name")
            )

            ->when($this->search, function ($query) {
                $query->where('course_sections.section', 'like', '%' . $this->search . '%');
            })
            // Apply course filter
            ->when($this->selectedCourse, function ($query) {
                $query->where('courses.course_id', $this->selectedCourse);
            })
            // Apply program filter
            ->when($this->selectedProgram, function ($query) {
                $query->where('programs.program_id', $this->selectedProgram);
            })
            // Apply faculty filter
            ->when($this->selectedFaculty, function ($query) {
                $query->where('faculties.faculty_id', $this->selectedFaculty);
            })
            // Apply sorting
            ->orderByRaw("faculty_name IS NULL, $this->sortField $this->sortDirection")
            // Pagination
            ->paginate(12);
    
        return view('livewire.section-crud', compact('sections'));
    }
    
    public $course_section_id, $course_id, $program_id, $faculty_id, $section;
    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;
    public $search = null, $deleteId, $selectedCourse = null, $selectedProgram = null, $selectedFaculty = null;
    public $sortField = 'created_at', $sortDirection = 'asc';

    protected $listeners = [
        'courseSelected' => 'courseSearch',
        'facultySelected' => 'facultySearch',
        'programSelected' => 'programSearch',
        'searchPerformed' => 'searchPerformed'
    ];

    protected $rules = [
        'section' => 'required|string|max:10',
        'faculty_id' => 'nullable|exists:faculties,faculty_id',  
        'program_id' => 'required|exists:programs,program_id',  
        'course_id' => 'required|exists:courses,course_id',
    ];
    

    public function searchPerformed($searchTerm)
    {
        $this->search = $searchTerm;
        $this->resetPage();
    }

    public function courseSearch($courseId)
    {
        $this->selectedCourse = $courseId;
        $this->resetPage();
    }

    public function programSearch($programId)
    {
        $this->selectedProgram = $programId;
        $this->resetPage();
    }

    public function facultySearch($facultyId)
    {
        $this->selectedFaculty = $facultyId;
        $this->resetPage();
    }

    public function sortBy($field)
    {
        $this->sortField = $this->sortField === $field ? $this->sortField : $field;
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    // Clear filters
    public function clearFilters()
    {
        $this->search = '';
        $this->selectedCourse = '';
        $this->selectedProgram = '';
        $this->selectedFaculty = '';
        $this->resetPage();
        $this->dispatch('clearFilters');
    }

    public function getCourses()
    {
        return Course::orderBy('course_name', 'asc')->get();
    }

    public function getPrograms()
    {
        return Program::orderBy('program_name', 'asc')->get();
    }

    public function getFaculties()
    {
        return Faculty::orderBy('first_name', 'asc')->get();
    }

    public function getDepartments()
    {
        return Department::all();
    }

        // Clear session messages
    public function clearMessage()
    {
        session()->forget(['success', 'error', 'info', 'deleted']);
    }








    // Method to edit course section data ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    public function edit($id)
    {
        $this->resetErrorBag(); // Reset any previous errors

        try {
            // Attempt to find the course section by ID
            $courseSection = CourseSection::findOrFail($id);

            // Populate input fields with course section data
            $this->course_section_id = $courseSection->course_section_id;
            $this->section = $courseSection->section;
            $this->faculty_id = $courseSection->faculty_id;
            $this->course_id = $courseSection->course_id;
            $this->program_id = $courseSection->program_id;

            // Show the edit form
            $this->showEditForm = true;
        } catch (ModelNotFoundException $e) {
            // Log error if course section is not found
            $this->logSystemError('Course section not found', $e);
        } catch (Exception $e) {
            // Log general errors
            $this->logSystemError('Failed to load course section', $e);
        }
    }

    // Step 2: Show update confirmation
    public function updateConfirmation()
    {
        // Check if any changes were made
        if (!$this->isUpdated()) {
            // If no changes, show a message and return
            session()->flash('info', 'No changes were made to the course section.');
            $this->showEditForm = false;
            $this->showEditConfirmation = false;
            return;
        }

        // Close the edit form and show confirmation if there are changes
        $this->showEditForm = false;
        $this->showEditConfirmation = true;
    }

    // Check if the course section data has been updated
    private function isUpdated()
    {
        $courseSection = CourseSection::find($this->course_section_id);
        return $courseSection && (
            $courseSection->faculty_id !== $this->faculty_id ||
            $courseSection->section !== $this->section 
        );
    }

    // Step 3: Confirm/Cancel update
    public function confirmUpdate()
    {
        $this->update(); // Process the update
        $this->closeEdit(); // Close the form after update
    }

    public function cancelUpdate()
    {
        $this->showEditConfirmation = false; // Close the confirmation modal
        $this->showEditForm = true; // Reopen the edit form
        $this->resetErrorBag(); // Reset error bag to clear any previous errors
    }

    // Function to update course section
    public function update()
    {
        try {
            // Only proceed with the update if changes were made
            if (!$this->isUpdated()) {
                session()->flash('info', 'No changes were made to the course section.');
                return;
            }

            // Validate and update the course section
            $this->validateQueryEdit();
        } catch (Exception $e) {
            // Handle any exceptions during the update process
            $this->logSystemError('An error occurred while updating the course section.', $e);
        } finally {
            // Reset input fields after the operation
            $this->resetInputFields();
        }
    }

    // Function to validate inputs and handle course section editing
    public function validateQueryEdit()
    {
        // Attempt to edit the course section and retrieve the updated course section object
        $courseSection = $this->editCourseSection();
        
        try {
            // Validate inputs using defined rules
            $this->validate($this->rules);

            // Save the course section changes to the database
            $courseSection->save();

            // Log the successful update along with changes and return a success response
            return $this->logEdit('Course section successfully updated!', $courseSection, 200);
        } catch (ValidationException $e) {
            // Handle validation errors (e.g., invalid inputs)
            return $this->logEditError('Invalid inputs!' . $e, $courseSection, 422);
        } catch (QueryException $e) {
            // Handle database-related errors
            if ($e->errorInfo[1] == 1062) {
                // Specific error for duplicate course section or code
                return $this->logEditError('Course section already exists!', $courseSection, 400);
            }

            // General database error
            return $this->logEditError('Database error: ' . $e->getMessage(), $courseSection, 500);
        }
    }

    // Function to retrieve and update the course section in the database
    private function editCourseSection()
    {
        // Retrieve the course section by its ID
        $courseSection = CourseSection::find($this->course_section_id);
    
        // If the course section doesn't exist, throw an exception
        if (!$courseSection) {
            throw new ModelNotFoundException('Course section not found!');
        }
    
        // Store old values to log changes later
        $this->oldValues = $courseSection->getOriginal();
    
        // Check if faculty_id is empty and set it to NULL if so
        $courseSection->faculty_id = ($this->faculty_id === '' || $this->faculty_id === 'null') ? NULL : $this->faculty_id;
    
        // Update other properties
        $courseSection->section = $this->section;
    
        // Save the updated course section
        $courseSection->save();
    
        // Return the updated course section object
        return $courseSection;
    }    

    // Log successful course section edit along with changes
    private function logEdit($message, $courseSection, $statusCode)
    {
        // Flash success message to the session
        session()->flash('success', $message);

        // Compare old and new values to log changes
        $changes = $this->compareChanges($this->oldValues, $courseSection->getAttributes());

        // Log the activity
        activity()
            ->performedOn($courseSection)
            ->causedBy(auth()->user())
            ->withProperties([
                'status' => 'success',
                'course_section_id' => $this->course_section_id,
                'status_code' => $statusCode,
                'changes' => $changes, // Include changes in the log
            ])
            ->event('Edit')
            ->log($message); // Log the success message
    }

    // Compare the old and new values to find changes
    private function compareChanges($oldValues, $newValues)
    {
        $changes = [];

        // Compare old and new values for each attribute
        foreach ($oldValues as $key => $oldValue) {
            if (array_key_exists($key, $newValues) && $oldValue !== $newValues[$key]) {
                $changes[$key] = [
                    'old' => $oldValue,
                    'new' => $newValues[$key]
                ];
            }
        }

        // Return the changes (if any)
        return $changes;
    }

    // Log edit error
    private function logEditError($message, $courseSection, $statusCode)
    {
        session()->flash('error', $message); // Flash error message

        activity()
            ->performedOn($courseSection)
            ->causedBy(auth()->user())
            ->withProperties([
                'status' => 'error',
                'course_section_id' => $this->course_section_id,
                'status_code' => $statusCode,
            ])
            ->event('Failed Edit')
            ->log($message); // Log activity
    }

    // Close all modals and reset the form
    public function closeEdit()
    {
        $this->showEditForm = false;
        $this->showEditConfirmation = false;
        $this->resetErrorBag(); // Reset error bag
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑





    // Method to initiate deletion process ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    public function delete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteConfirmation = true;
    }
    // If confirmed
    public function confirmDelete()
    {
        $this->remove(); // Proceed to delete section from database
        $this->resetDeleteState(); // Close confirmation modal and reset state
    }

    // If canceled
    public function cancelDelete()
    {
        $this->resetDeleteState(); // Close confirmation modal and reset state
    }

    private function resetDeleteState()
    {
        $this->showDeleteConfirmation = false;
        $this->deleteId = null;
    }

    // Main method to handle section deletion
    public function remove()
    {
        try {
            $this->validateQueryRemove(); // Validate and check if the section can be deleted
        } catch (Exception $e) {
            $this->logSystemError('An error occurred while deleting the section.', $e);
        } finally {
            session()->forget('deleteId');
        }
    }
    public function validateQueryRemove()
    {
        try {
            // Retrieve section by ID
            $section = CourseSection::find($this->deleteId);

            if (!$section) {
                return $this->logRemoveError('Section not found!', $section, 404);
            }

            // Check if a faculty member is teaching the section
            if ($section->faculty_id) { 
                return $this->logRemoveError('Cannot delete the section as it is currently being taught by a faculty member.', $section, 400);
            }

            // Check if students are enrolled in the section
            if ($section->students()->exists()) { 
                return $this->logRemoveError('Cannot delete the section as students are enrolled in it.', $section, 400);
            }

            // Soft delete the section
            $this->deleteSection($section);

        } catch (QueryException $e) {
            // Handle database query exceptions
            return $this->logRemoveError('Database error: ' . $e->getMessage(), $section, 500);
        }
    }
    // Soft delete the section and log success
    private function deleteSection($section)
    {
        $section->delete();  // Perform soft delete

        // Log the successful deletion
        return $this->logRemove('Section successfully deleted!', $section, 200);
    }
    // Log successful section removal
    private function logRemove($message, $section, $statusCode)
    {
        // Flash deleted id for restoration to the session
        session()->put('deleted_record_id', $this->deleteId);

        // Flash success message to the session
        session()->flash('deleted', $message);

        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($section)
            ->causedBy(auth()->user())
            ->withProperties([
                'status' => 'success',  // Status: success
                'section' => $section->section, // Log section code for reference
                'status_code' => $statusCode, // HTTP status code (e.g., 200 for successful removal)
            ])
            ->event('Section Removed') // Event: Section Removed
            ->log($message); // Log the custom success message
    }

    // Log an error when section removal fails
    private function logRemoveError($message, $section, $statusCode)
    {
        // Flash error message to the session
        session()->flash('error', $message);

        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($section)
            ->causedBy(auth()->user())
            ->withProperties([
                'status' => 'error',  // Status: error
                'section' => $section->section, // Log section code for reference
                'status_code' => $statusCode, // HTTP status code (e.g., 400, 422 for failure cases)
            ])
            ->event('Failed to Remove Section') // Event: Failed to Remove Section
            ->log($message); // Log the custom error message
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑





    // Method to initiate restoration process ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    public function undoDelete()
    {
        // Get the deleted section ID from the session
        $sectionId = session()->get('deleted_record_id');

        if ($sectionId) {
            try {
                // Retrieve the section including trashed ones
                $section = CourseSection::withTrashed()->findOrFail($sectionId);

                // Check if the section is already active or needs restoration
                $this->checkIfRestored($section);
            } catch (ModelNotFoundException $e) {
                // Log error if section is not found
                $this->logSystemError('Section not found for restoration!', $e);
            } catch (Exception $e) {
                // Log any other exceptions
                $this->logSystemError('Failed to restore section', $e);
            }
        } else {
            // Handle case where no deleted section is found in session
            session()->flash('error', 'No section available to restore!');
        }
    }

    // Check if the section is already restored
    private function checkIfRestored($section)
    {
        if (!$section->trashed()) {
            // Log if the section is already active
            $this->logRestorationError('Section is already active', $section);
            return;
        } else {
            // Restore the section if it’s trashed
            $this->restoreSection($section);
        }
    }

    // Restore the section
    private function restoreSection($section)
    {
        try {
            // Attempt to restore the section
            $section->restore();
            
            // Clear the session for deleted section ID
            session()->forget('deleted_record_id');

            // Log the restoration success
            $this->logRestoration('Section successfully restored!', $section, 200);
        } catch (Exception $e) {
            // Log any errors during the restoration process
            $this->logRestorationError('Failed to restore section', $section, 500);
        }
    }

    // Log the section restoration
    private function logRestoration($message, $section, $statusCode)
    {
        session()->flash('success', $message);

        // Log activity using Spatie Activitylog
        activity()
            ->performedOn($section)
            ->causedBy(auth()->user())
            ->withProperties([
                'status' => 'success',
                'section' => $section->section,
                'status_code' => $statusCode,
            ])
            ->event('Restore')
            ->log('Section restored');
    }

    // Log restoration error
    private function logRestorationError($message, $section, $statusCode)
    {
        session()->flash('error', $message);

        // Log activity using Spatie Activitylog
        activity()
            ->performedOn($section)
            ->causedBy(auth()->user())
            ->withProperties([
                'status' => 'error',
                'section' => $section->section,
                'status_code' => $statusCode,
            ])
            ->event('Restore')
            ->log('Failed to restore section');
    }

    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑












    // Function to show the add section form ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    public function add()
    {
        $this->resetErrorBag(); // Reset any validation errors
        $this->resetInputFields(); // Reset all input fields to their initial state
        $this->showAddForm = true; // Show the add form modal for the user to enter data
    }

    // Function to store the section information
    public function store()
    {
        try {
            // Attempt to validate and create the section
            $this->validateQueryStore();
        } catch (Exception $e) {
            // If an unexpected error occurs, log the system error
            $this->logSystemError('An error occurred while storing the section.', $e);
        } finally {
            // Reset input fields after the operation, regardless of success or failure
            $this->resetInputFields();
        }
    }

    // Function to show the confirmation modal after clicking "Store"
    public function storeConfirmation() 
    {
        if ($this->isPopulated()) {
            $this->showAddForm = false; // Close the add form modal
            $this->showAddConfirmation = true; // Show the confirmation modal
        } else {
            session()->flash('info', 'Please fill in all required fields before proceeding.'); // Error message
            $this->showAddForm = false; // Close the add form modal
        }
    }

    // Function to check if form is empty
    public function isPopulated()
    {
        return !empty($this->section) ||
            !empty($this->course_id) ||
            !empty($this->program_id);
    }

    // Function that is called if the user confirms to store the section
    public function confirmStore() 
    {
        $this->store(); // Call the store method to save the new section
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->showAddForm = false; // Close the add form modal
        $this->resetInputFields(); // Reset the input fields after storing the section
    }

    // Function that is called if the user cancels the store action
    public function cancelStore() 
    {
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->showAddForm = true; // Show the add form modal again
        $this->resetErrorBag(); // Reset any validation errors
    }

    // Function to validate inputs and handle section creation
    public function validateQueryStore() 
    {
        // Initialize $section with the intended input values
        $section = new CourseSection([
            'section' => $this->section,
            'course_id' => $this->course_id,
            'faculty_id' => $this->faculty_id,
            'program_id' => $this->program_id,
        ]);

        try {
            // Validate inputs using the $rules property
            $this->validate($this->rules);

            // Check if a section with the same name exists for the given course
            $existingSection = CourseSection::where('section', $this->section)
                ->where('course_id', $this->course_id)
                ->first();

            if ($existingSection) {
                // Log error if section already exists for the course
                return $this->logAddError('Section already exists!', $section, 409);
            }

            // Attempt to create the section
            $section = $this->createSection();

            // Log success and return a success response
            return $this->logAdd('Section successfully added!', $section, 201);

        } catch (ValidationException $e) {
            // Log validation error with the initialized $section
            return $this->logAddError('Invalid inputs!', $section, 422);

        } catch (QueryException $e) {
            // Handle duplicate entry error
            if ($e->errorInfo[1] == 1062) {
                return $this->logAddError('Section code or name already exists!', $section, 400);
            }

            // Handle other SQL errors
            return $this->logAddError('Database error: ' . $e->getMessage(), $section, 500);
        }
    }

    // Function to create the section entry in the database
    private function createSection()
    {
        return CourseSection::create([
            'section' => $this->section,
            'course_id' => $this->course_id,
            'faculty_id' => $this->faculty_id,
            'program_id' => $this->program_id,
        ]);
    }

    // Function to log a successful section creation
    private function logAdd($message, $section, $statusCode)
    {
        // Flash success message to the session for user feedback
        session()->flash('success', $message);
        
        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($section) // Attach the log to the section object
            ->causedBy(auth()->user()) // Associate the logged action with the authenticated user
            ->withProperties([ // Add any additional properties to log
                'status' => 'success', // Mark the status as success
                'section' => $this->section,  // Log the section name for reference
                'status_code' => $statusCode, // Log the HTTP status code (e.g., 201 for created)
            ])
            ->event('Section Created') // Set the event name as "Section Created"
            ->log($message); // Log the custom success message
    }

    // Function to log an error when section creation fails
    private function logAddError($message, $statusCode)
    {
        // Flash error message to the session for user feedback
        session()->flash('error', $message);
        
        // Log the activity using Spatie Activitylog
        activity()
            ->causedBy(auth()->user()) // Associate the logged action with the authenticated user
            ->withProperties([ // Add any additional properties to log
                'status' => 'error', // Mark the status as error
                'status_code' => $statusCode, // Log the HTTP status code (e.g., 422 for validation errors)
            ])
            ->event('Failed to Add Section') // Set the event name as "Failed to Add Section"
            ->log($message); // Log the custom error message
    }

    // Function to close the add section form and reset everything
    public function closeAdd() 
    {
        $this->showAddForm = false; // Close the add form modal
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->resetInputFields(); // Reset input fields
        $this->resetErrorBag(); // Reset any validation errors
    }







    // Log unexpected system errors
    private function logSystemError($message, Exception $e)
    {
        // Capture essential error details
        $errorMessage = $e->getMessage(); // Error message
        $errorCode = $e->getCode(); // Error code (if available)
        $errorTrace = $e->getTraceAsString(); // Stack trace (for debugging)

        // Log the error information to the session
        session()->flash('error', $message);

        // Log the activity using Spatie Activitylog
        activity()
            ->causedBy(auth()->user()) // Associate the logged action with the authenticated user
            ->withProperties([ // Log essential error information
                'error_message' => $errorMessage, // Error message
                'error_code' => $errorCode, // Error code
                'error_stack' => $errorTrace, // Stack trace for debugging
                'status' => 'error', // Custom status for the log entry
            ])
            ->event('System Error') // Event name for clarity
            ->log($message); // Log the custom error message

        // Optionally, log the error to the Laravel log file as well
        \Log::error($message, [
            'exception' => [
                'message' => $errorMessage,
                'code' => $errorCode,
                'trace' => $errorTrace
            ]
        ]);
    }

     // Function to reset all input fields
     private function resetInputFields()
    {
        // Reset specific input fields to their initial state
        $this->reset(['faculty_id', 'section', 'course_id', 'program_id']);
    }
}

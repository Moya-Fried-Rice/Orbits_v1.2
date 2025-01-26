<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;

use Livewire\Component;

use App\Models\Section;
use App\Models\Department;
use App\Models\Program;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Livewire\WithPagination;

class SectionCrud extends Component
{
    use WithPagination;

    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Properties
    public $section_id, $year_level, $section_number, $program_id, $section_code;
    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;
    public $search = null, $deleteId, $selectedProgram = null;
    public $sortField = 'created_at', $sortDirection = 'asc';
    public $section_output;

    use WithPagination;
    // Method to handle rendering
    public function render()
    {
        $sections = Section::query()
            ->selectRaw('sections.*, CONCAT(programs.abbreviation, sections.year_level, "0", sections.section_number) AS section_code')
            ->leftJoin('programs', 'sections.program_id', '=', 'programs.program_id') // Join with programs table
            ->when($this->selectedProgram, function ($query) {
                return $query->where('programs.program_id', $this->selectedProgram); // Use selectedProgram for filtering
            })
            ->when($this->search, function ($query) {
                $query->having('section_code', 'like', '%' . $this->search . '%'); // Use HAVING for virtual column filtering
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(11); // Adjust pagination as needed
    
        return view('livewire.section-crud', compact('sections'));
    }
    
    public function updated()
    {
        if ($this->program_id) {
            $program = Program::find($this->program_id);
            $this->section_code = $program ? $program->abbreviation : 'N/A';
        } else {
            $this->section_code = ' ';
        }
        // Initialize section_output with default values
        $this->section_output = $this->section_code . $this->year_level . '0' . $this->section_number;
    }
    
    // Listen to dispatched events
    protected $listeners = [
        'programSelected' => 'programSearch',
        'searchPerformed' => 'searchPerformed'
    ];

    // Validation rules
    protected $rules = [
        'year_level' => 'required|integer|min:1|max:4', // Validates year level as an integer between 1 and 4
        'section_number' => 'required|integer', // Ensures the section number is unique for each course
        'program_id' => 'required|exists:programs,program_id', // Ensures the program exists in the database
    ];

    // Search Section
    public function searchPerformed($searchTerm)
    {
        $this->search = $searchTerm;
        $this->resetPage();
    }

    // Filter section by program
    public function programSearch($programId)
    {
        $this->selectedProgram = $programId;
        $this->resetPage();
    }

    // Sort courses by field and direction
    public function sortBy($field)
    {
        $this->sortField = $this->sortField === $field ? $this->sortField : $field;
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    // Clear filters
    public function clearFilters()
    {
        $this->search = '';
        $this->selectedProgram = '';
        $this->resetPage();
        $this->dispatch('clearFilters');
    }

    // Fetch all programs for dropdown
    public function getPrograms()
    {
        return Program::all();
    }

    // Fetch all departments for dropdown 
        public function getDepartments()
    {
        return Department::all();
    }

    // Clear session messages
    public function clearMessage()
    {
        session()->forget(['success', 'error', 'info', 'deleted']);
    }

    public function ordinal($number)
    {
        $suffixes = ['th', 'st', 'nd', 'rd'];
        $value = $number % 100;

        return $number . ($suffixes[($value - 20) % 10] ?? $suffixes[$value] ?? $suffixes[0]);
    }

    // Reset specific input fields to their initial state
    private function resetInputFields()
    {
        $this->reset(['section_id', 'program_id', 'year_level', 'section_number']);
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Method to initiate deletion process
    public function delete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteConfirmation = true;
    }

    // Step 2: Confirm/Cancel delete

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

    // Reset delete state to prepare for next action
    private function resetDeleteState()
    {
        $this->showDeleteConfirmation = false;
        $this->deleteId = null;
    }

    // Main method to handle deletion
    public function remove()
    {
        try {
            $this->validateQueryRemove();
        } catch (Exception $e) {
            $this->logSystemError('An error occurred while deleting the section.', $e);
        } finally {
            session()->forget('deleteId');
        }
    }

    // Validate and process deletion
    public function validateQueryRemove()
    {
        try {
            // Retrieve section by ID
            $section = Section::find($this->deleteId);

            if (!$section) {
                return $this->logRemoveError('Section not found!', $section, 404);
            }

            // Check for related records (dependencies) that prevent deletion
            if ($section->courseSection()->exists()) { 
                return $this->logRemoveError('Cannot delete the section as it currently contains enrolled courses.', $section, 400);
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
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'success',  // Status: success
                'section_id' => $section->section_id, // Log section ID for reference
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
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'error',  // Status: error
                'section_id' => $section->section_id, // Log section ID for reference
                'status_code' => $statusCode, // HTTP status code (e.g., 400, 422 for failure cases)
            ])
            ->event('Failed to Remove Section') // Event: Failed to Remove Section
            ->log($message); // Log the custom error message
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Method to add new section
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
        return !empty($this->program_id) || !empty($this->year_level) || !empty($this->section_number);
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
        $section = new Section([
            'program_id' => $this->program_id,
            'year_level' => $this->year_level,
            'section_number' => $this->section_number,
        ]);

        try {
            // Validate inputs using the $rules property
            $this->validate($this->rules);

            // Attempt to create the section
            $section = $this->createSection();

            // Log success and return a success response
            return $this->logAdd('Section successfully added!', $section, 201);

        } catch (ValidationException $e) {
            // Log validation error with the initialized $section
            $errors = $e->validator->errors()->all();
            $errorMessages = implode(' | ', $errors);

            return $this->logAddError('Invalid inputs: ' . $errorMessages, $section, 422);

        } catch (QueryException $e) {
            // Handle duplicate entry error
            if ($e->errorInfo[1] == 1062) {
                return $this->logAddError('This section already exists!', $section, 400);
            }

            // Handle other SQL errors
            return $this->logAddError('Database error: ' . $e->getMessage(), $section, 500);
        }
    }

    // Function to create the section entry in the database
    private function createSection()
    {
        // Check for a soft-deleted record with the same `section_id`, `year_level`, and `section_number`
        $existingSection = Section::withTrashed()->where([
            'program_id' => $this->program_id, // Handle null case
            'year_level' => $this->year_level,
            'section_number' => $this->section_number,
        ])->first();
    
        if ($existingSection) {
            if ($existingSection->trashed()) {
                // Restore the soft-deleted record
                $existingSection->restore();
                return $existingSection;
            }
        }
    
        // If no matching record exists, create a new one
        return Section::create([
            'program_id' => $this->program_id, // Use null if no section
            'year_level' => $this->year_level,
            'section_number' => $this->section_number,
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
            ->causedBy(Auth::user()) // Associate the logged action with the authenticated user
            ->withProperties([ // Add any additional properties to log
                'status' => 'success', // Mark the status as success
                'program_id' => $this->program_id,
                'status_code' => $statusCode, // Log the HTTP status code (e.g., 201 for created)
            ])
            ->event('Section Created') // Set the event name as "Section Created"
            ->log($message); // Log the custom success message
    }

    // Function to log an error when section creation fails
    private function logAddError($message, $section, $statusCode)
    {
        // Flash error message to the session for user feedback
        session()->flash('error', $message);
        
        // Log the activity using Spatie Activitylog
        activity()
            ->causedBy(Auth::user()) // Associate the logged action with the authenticated user
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
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Method for restoring deleted section
    public function undoDelete()
    {
        // Get the deleted section ID from the session
        $sectionId = session()->get('deleted_record_id');

        if ($sectionId) {
            try {
                // Retrieve the section including trashed ones
                $section = Section::withTrashed()->findOrFail($sectionId);

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
            $this->logRestorationError('Section is already active', $section, 400);
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
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'success',
                'section_name' => $section->name,  // Use section name instead of course name
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
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'error',
                'section_name' => $section->name,  // Use section name instead of course name
                'status_code' => $statusCode,
            ])
            ->event('Restore')
            ->log('Failed to restore section');
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
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
            ->causedBy(Auth::user()) // Associate the logged action with the authenticated user
            ->withProperties([ // Log essential error information
                'error_message' => $errorMessage, // Error message
                'error_code' => $errorCode, // Error code
                'error_stack' => $errorTrace, // Stack trace for debugging
                'status' => 'error', // Custom status for the log entry
            ])
            ->event('System Error') // Event name for clarity
            ->log($message); // Log the custom error message
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
}
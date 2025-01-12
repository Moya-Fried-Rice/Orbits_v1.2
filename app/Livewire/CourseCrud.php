<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Department;
use Spatie\Activitylog\Traits\LogsActivity;
use Livewire\WithPagination;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class CourseCrud extends Component
{
    use WithPagination;

    // Render everything
    public function render()
    {
        $courses = Course::query()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('course_name', 'like', '%' . $this->search . '%')
                        ->orWhere('course_code', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedDepartment, fn($query) => $query->where('department_id', $this->selectedDepartment))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(12);

        return view('livewire.course-crud', compact('courses'));
    }

    // Public properties for course data and modal states.
    public $course_id, $course_name, $course_description, $course_code, $department_id;
    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;
    public $search = null, $deleteId, $selectedDepartment = null;
    public $sortField = 'created_at', $sortDirection = 'asc';

    // Listen to dispatched events
    protected $listeners = [
        'departmentSelected' => 'departmentSearch',
        'searchPerformed' => 'searchPerformed'
    ];

    // Validation rules
    protected $rules = [
        'course_name' => 'required|string|max:255',
        'course_code' => 'required|string|max:50',
        'course_description' => 'nullable|string|max:500',
        'department_id' => 'required|exists:departments,department_id',
    ];

    // Search courses
    public function searchPerformed($searchTerm)
    {
        $this->search = $searchTerm;
        $this->resetPage();
    }

    // Filter courses by department
    public function departmentSearch($departmentId)
    {
        $this->selectedDepartment = $departmentId;
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
        $this->selectedDepartment = '';
        $this->resetPage();
        $this->dispatch('clearFilters');
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

    // Method to edit course data ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    public function edit($id)
    {
        $this->resetErrorBag(); // Reset any previous errors
    
        try {
            // Attempt to find the course by ID
            $course = Course::findOrFail($id);
    
            // Populate input fields with course data
            $this->course_id = $course->course_id;
            $this->course_name = $course->course_name;
            $this->course_description = $course->course_description;
            $this->course_code = $course->course_code;
            $this->department_id = $course->department_id;
    
            // Show the edit form
            $this->showEditForm = true;
        } catch (ModelNotFoundException $e) {
            // Log error if course is not found
            $this->logSystemError('Course not found', $e);
        } catch (Exception $e) {
            // Log general errors
            $this->logSystemError('Failed to load course', $e);
        }
    }
    
    // Step 2: Show update confirmation
    public function updateConfirmation()
    {
    
        // Check if any changes were made
        if (!$this->isUpdated()) {
            // If no changes, show a message and return
            session()->flash('info', 'No changes were made to the course.');
            $this->showEditForm = false;
            $this->showEditConfirmation = false;
            return;
        }
    
        // Close the edit form and show confirmation if there are changes
        $this->showEditForm = false;
        $this->showEditConfirmation = true;
    }

    // Check if the course data has been updated
    private function isUpdated()
    {
        $course = Course::find($this->course_id);
        return $course && (
            $course->course_name !== $this->course_name ||
            $course->course_description !== $this->course_description ||
            $course->course_code !== $this->course_code ||
            $course->department_id !== $this->department_id
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
    
    // Function to update course
    public function update()
    {
        try {
            // Only proceed with the update if changes were made
            if (!$this->isUpdated()) {
                session()->flash('info', 'No changes were made to the course.');
                return;
            }
    
            // Validate and update the course
            $this->validateQueryEdit();
        } catch (Exception $e) {
            // Handle any exceptions during the update process
            $this->logSystemError('An error occurred while updating the course.', $e);
        } finally {
            // Reset input fields after the operation
            $this->resetInputFields();
        }
    }
    
    // Function to validate inputs and handle course editing
    public function validateQueryEdit()
    {
        // Attempt to edit the course and retrieve the updated course object
        $course = $this->editCourse();
        
        try {
            // Validate inputs using defined rules
            $this->validate($this->rules);

            // Save the course changes to the database
            $course->save();

            // Log the successful update along with changes and return a success response
            return $this->logEdit('Course successfully updated!', $course, 200);
        } catch (ValidationException $e) {
            // Handle validation errors (e.g., invalid inputs)
            return $this->logEditError('Invalid inputs!', $course, 422);
        } catch (QueryException $e) {
            // Handle database-related errors
            if ($e->errorInfo[1] == 1062) {
                // Specific error for duplicate course code or name
                return $this->logEditError('Course code or name already exists!', $course, 400);
            }

            // General database error
            return $this->logEditError('Database error: ' . $e->getMessage(), $course, 500);
        }
    }

    // Function to retrieve and update the course in the database
    private function editCourse()
    {
        // Retrieve the course by its ID
        $course = Course::find($this->course_id);

        // If the course doesn't exist, throw an exception
        if (!$course) {
            throw new ModelNotFoundException('Course not found!');
        }

        // Store old values to log changes later
        $this->oldValues = $course->getOriginal();

        // Update the course properties with new values
        $course->course_name = $this->course_name;
        $course->course_description = $this->course_description;
        $course->course_code = $this->course_code;
        $course->department_id = $this->department_id;

        // Return the updated course object
        return $course;
    }

    // Log successful course edit along with changes
    private function logEdit($message, $course, $statusCode)
    {
        // Flash success message to the session
        session()->flash('success', $message);

        // Compare old and new values to log changes
        $changes = $this->compareChanges($this->oldValues, $course->getAttributes());

        // Log the activity
        activity()
            ->performedOn($course)
            ->causedBy(auth()->user())
            ->withProperties([
                'status' => 'success',
                'course_name' => $this->course_name,
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
    private function logEditError($message, $course, $statusCode)
    {
        session()->flash('error', $message); // Flash error message
    
        activity()
            ->performedOn($course)
            ->causedBy(auth()->user())
            ->withProperties([
                'status' => 'error',
                'course_name' => $this->course_name,
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

    // Step 2: Confirm/Cancel delete

    // If confirmed
    public function confirmDelete()
    {
        $this->remove(); // Proceed to delete course from database
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
            $this->logSystemError('An error occurred while deleting the course.', $e);
        } finally {
            session()->forget('deleteId');
        }
    }

    // Validate and process deletion
    public function validateQueryRemove()
    {
        try {
            // Retrieve course by ID
            $course = Course::find($this->deleteId);

            if (!$course) {
                return $this->logRemoveError('Course not found!', $course, 404);
            }

            // Check for related records (dependencies) that prevent deletion
            if ($course->courseSections()->exists()) { 
                return $this->logRemoveError('Cannot delete the course due to existing dependencies.', $course, 400);
            }

            // Soft delete the course
            $this->deleteCourse($course);

        } catch (QueryException $e) {
            // Handle database query exceptions
            return $this->logRemoveError('Database error: ' . $e->getMessage(), $course, 500);
        }
    }

    // Soft delete the course and log success
    private function deleteCourse($course)
    {
        $course->delete();  // Perform soft delete

        // Log the successful deletion
        return $this->logRemove('Course successfully deleted!', $course, 200);
    }

    // Log successful course removal
    private function logRemove($message, $course, $statusCode)
    {
        // Flash deleted id for restoration to the session
        session()->put('deleted_record_id', $this->deleteId);

        // Flash success message to the session
        session()->flash('deleted', $message);

        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($course)
            ->causedBy(auth()->user())
            ->withProperties([
                'status' => 'success',  // Status: success
                'course_name' => $course->course_name, // Log course name for reference
                'status_code' => $statusCode, // HTTP status code (e.g., 200 for successful removal)
            ])
            ->event('Course Removed') // Event: Course Removed
            ->log($message); // Log the custom success message
    }

    // Log an error when course removal fails
    private function logRemoveError($message, $course, $statusCode)
    {
        // Flash error message to the session
        session()->flash('error', $message);

        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($course)
            ->causedBy(auth()->user())
            ->withProperties([
                'status' => 'error',  // Status: error
                'course_name' => $course->course_name, // Log course name for reference
                'status_code' => $statusCode, // HTTP status code (e.g., 400, 422 for failure cases)
            ])
            ->event('Failed to Remove Course') // Event: Failed to Remove Course
            ->log($message); // Log the custom error message
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑





    // Method for restoring deleted course ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    public function undoDelete()
    {
        // Get the deleted course ID from the session
        $courseId = session()->get('deleted_record_id');

        if ($courseId) {
            try {
                // Retrieve the course including trashed ones
                $course = Course::withTrashed()->findOrFail($courseId);

                // Check if the course is already active or needs restoration
                $this->checkIfRestored($course);
            } catch (ModelNotFoundException $e) {
                // Log error if course is not found
                $this->logSystemError('Course not found for restoration!', $e);
            } catch (Exception $e) {
                // Log any other exceptions
                $this->logSystemError('Failed to restore course', $e);
            }
        } else {
            // Handle case where no deleted course is found in session
            session()->flash('error', 'No course available to restore!');
        }
    }

    // Check if the course is already restored
    private function checkIfRestored($course)
    {
        if (!$course->trashed()) {
            // Log if the course is already active
            $this->logRestorationError('Course is already active', $course);
            return;
        } else {
            // Restore the course if it’s trashed
            $this->restoreCourse($course);
        }
    }

    // Restore the course
    private function restoreCourse($course)
    {
        try {
            // Attempt to restore the course
            $course->restore();
            
            // Clear the session for deleted course ID
            session()->forget('deleted_record_id');

            // Log the restoration success
            $this->logRestoration('Course successfully restored!', $course, 200);
        } catch (Exception $e) {
            // Log any errors during the restoration process
            $this->logRestorationError('Failed to restore course', $course, 500);
        }
    }

    // Log the course restoration
    private function logRestoration($message, $course, $statusCode)
    {
        session()->flash('success', $message);

        // Log activity using Spatie Activitylog
        activity()
            ->performedOn($course)
            ->causedBy(auth()->user())
            ->withProperties([
                'status' => 'success',
                'course_name' => $course->course_name,
                'status_code' => $statusCode,
            ])
            ->event('Restore')
            ->log('Course restored');
    }

    // Log restoration error
    private function logRestorationError($message, $course, $statusCode)
    {
        session()->flash('error', $message);

        // Log activity using Spatie Activitylog
        activity()
            ->performedOn($course)
            ->causedBy(auth()->user())
            ->withProperties([
                'status' => 'error',
                'course_name' => $course->course_name,
                'status_code' => $statusCode,
            ])
            ->event('Restore')
            ->log('Failed to restore course');
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑





    // Function to show the add course form ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    public function add()
    {
        $this->resetErrorBag(); // Reset any validation errors
        $this->resetInputFields(); // Reset all input fields to their initial state
        $this->showAddForm = true; // Show the add form modal for the user to enter data
    }

    // Function to store the course information
    public function store()
    {
        try {
            // Attempt to validate and create the course
            $this->validateQueryStore();
        } catch (Exception $e) {
            // If an unexpected error occurs, log the system error
            $this->logSystemError('An error occurred while storing the course.', $e);
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
        return !empty($this->course_name) ||
            !empty($this->course_description) ||
            !empty($this->course_code) ||
            !empty($this->department_id);
    }

    // Function that is called if the user confirms to store the course
    public function confirmStore() 
    {
        $this->store(); // Call the store method to save the new course
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->showAddForm = false; // Close the add form modal
        $this->resetInputFields(); // Reset the input fields after storing the course
    }

    // Function that is called if the user cancels the store action
    public function cancelStore() 
    {
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->showAddForm = true; // Show the add form modal again
        $this->resetErrorBag(); // Reset any validation errors
    }

    // Function to validate inputs and handle course creation
    public function validateQueryStore() 
    {
        // Initialize $course with the intended input values
        $course = new Course([
            'course_name' => $this->course_name,
            'course_description' => $this->course_description,
            'course_code' => $this->course_code,
            'department_id' => $this->department_id,
        ]);

        try {
            // Validate inputs using the $rules property
            $this->validate($this->rules);

            // Attempt to create the course
            $course = $this->createCourse();

            // Log success and return a success response
            return $this->logAdd('Course successfully added!', $course, 201);

        } catch (ValidationException $e) {
            // Log validation error with the initialized $course
            return $this->logAddError('Invalid inputs!', $course, 422);

        } catch (QueryException $e) {
            // Handle duplicate entry error
            if ($e->errorInfo[1] == 1062) {
                return $this->logAddError('Course code or name already exists!', $course, 400);
            }

            // Handle other SQL errors
            return $this->logAddError('Database error: ' . $e->getMessage(), $course, 500);
        }
    }

    // Function to create the course entry in the database
    private function createCourse()
    {
        return Course::create([
            'course_name' => $this->course_name,
            'course_description' => $this->course_description,
            'course_code' => $this->course_code,
            'department_id' => $this->department_id,
        ]);
    }

    // Function to log a successful course creation
    private function logAdd($message, $course, $statusCode)
    {
        // Flash success message to the session for user feedback
        session()->flash('success', $message);
        
        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($course) // Attach the log to the course object
            ->causedBy(auth()->user()) // Associate the logged action with the authenticated user
            ->withProperties([ // Add any additional properties to log
                'status' => 'success', // Mark the status as success
                'course_name' => $this->course_name,  // Log the course name for reference
                'status_code' => $statusCode, // Log the HTTP status code (e.g., 201 for created)
            ])
            ->event('Course Created') // Set the event name as "Course Created"
            ->log($message); // Log the custom success message
    }

    // Function to log an error when course creation fails
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
            ->event('Failed to Add Course') // Set the event name as "Failed to Add Course"
            ->log($message); // Log the custom error message
    }

    // Function to close the add course form and reset everything
    public function closeAdd() 
    {
        $this->showAddForm = false; // Close the add form modal
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->resetInputFields(); // Reset input fields
        $this->resetErrorBag(); // Reset any validation errors
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

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
        $this->reset(['course_id', 'course_name', 'course_code', 'course_description', 'department_id']);
    }
}

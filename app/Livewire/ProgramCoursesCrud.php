<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Livewire\Component;
use App\Models\Program;
use App\Models\ProgramCourse;
use App\Models\Department;

class ProgramCoursesCrud extends Component
{

    public $uuid;
    public $program_id, $program_name, $program_code, $abbreviation, 
    $program_description, $department_id, $programCourse, $course_id, $year_level, $semester;
    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;
    public $deleteId;
    public $oldValues;
    
    public function render()
    {
        // Retrieve the section data based on the provided UUID
        $program = $this->getProgramByUuid($this->uuid);

        // Render the view with the section data
        return view('livewire.program-courses-crud', compact('program'));
    }

    protected $rules = [
        'program_name' => 'required|string|max:255', // Required, must be unique
        'program_code' => 'required|string|max:50', // Required, must be unique
        'abbreviation' => 'nullable|string|max:10', // Optional, string, max length of 10
        'program_description' => 'nullable|string|max:1000', // Optional, string, max length of 1000
        'department_id' => 'required|integer|exists:departments,department_id', // Required, must be an integer, and exist in the 'departments' table
    ];

    protected function getProgramByUuid($uuid)
    {
        // Return the Section record along with its associated course section
        return Program::with('programCourse')->where('uuid', $uuid)->first();
    }

    public function clearMessage()
    {
        // Clear any session messages such as success, error, or info
        session()->forget(['success', 'error', 'info', 'deleted']);
    }

    public function getDepartments()
    {
        // Retrieve all departments
        return Department::all();
    }

    public function ordinal($number)
    {
        $suffixes = ['th', 'st', 'nd', 'rd'];
        $value = $number % 100;

        return $number . ($suffixes[($value - 20) % 10] ?? $suffixes[$value] ?? $suffixes[0]);
    }

    public function ordinalWord($number)
    {
        switch ($number) {
            case 1:
                return 'First';
            case 2:
                return 'Second';
            case 3:
                return 'Third';
            case 4:
                return 'Fourth';
            case 5:
                return 'Fifth';
            case 6:
                return 'Sixth';
            case 7:
                return 'Seventh';
            case 8:
                return 'Eighth';
            case 9:
                return 'Ninth';
            case 10:
                return 'Tenth';
            default:
                return $number . 'th'; // Default case for numbers 11 and above
        }
    }

    private function resetInputFields()
    {
        // Reset all form input fields to their initial values
        $this->reset([
            'program_id',
            'program_name',
            'program_code',
            'abbreviation',
            'program_description',
            'department_id',
            'course_id',
            'year_level',
            'semester'
        ]);
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Method to edit program data
    public function edit($id)
    {
        $this->resetErrorBag();

        try {
            $program = Program::findOrFail($id);

            // Populate input fields with program data
            $this->program_id = $program->program_id;
            $this->program_code = $program->program_code;
            $this->program_name = $program->program_name;
            $this->abbreviation = $program->abbreviation;
            $this->program_description = $program->program_description;
            $this->department_id = $program->department_id;

            // Show the edit form
            $this->showEditForm = true;
        } catch (ModelNotFoundException $e) {
            // Log error if program is not found
            $this->logSystemError('Program not found', $e);
        } catch (Exception $e) {
            // Log general errors
            $this->logSystemError('Failed to load program', $e);
        }
    }

    // Step 2: Show update confirmation
    public function updateConfirmation()
    {
        // Check if any changes were made
        if (!$this->isUpdated()) {
            session()->flash('info', 'No changes were made to the program.');
            $this->showEditForm = false;
            $this->showEditConfirmation = false;
            return;
        }

        // Close the edit form and show confirmation if there are changes
        $this->showEditForm = false;
        $this->showEditConfirmation = true;
    }

    // Check if the program data has been updated
    private function isUpdated()
    {
        $program = Program::find($this->program_id);
        return $program && (
            $program->program_code !== $this->program_code ||
            $program->program_name !== $this->program_name ||
            $program->abbreviation !== $this->abbreviation ||
            $program->program_description !== $this->program_description ||
            $program->department_id !== $this->department_id
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

    // Function to update program
    public function update()
    {
        try {
            if (!$this->isUpdated()) {
                session()->flash('info', 'No changes were made to the program.');
                return;
            }

            $this->validateQueryEdit();
        } catch (Exception $e) {
            $this->logSystemError('An error occurred while updating the program.', $e);
        } finally {
            $this->resetInputFields();
        }
    }

    // Function to validate inputs and handle program editing
    public function validateQueryEdit()
    {
        $program = $this->editProgram();

        try {
            $this->validate($this->rules);

            $program->save();

            return $this->logEdit('Program successfully updated!', $program, 200);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            $errorMessages = implode(' | ', $errors);

            return $this->logEditError('Invalid inputs: ' . $errorMessages, $program, 422);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return $this->logEditError('Program name already exists!', $program, 400);
            }

            return $this->logEditError('Database error: ' . $e->getMessage(), $program, 500);
        }
    }

    // Function to retrieve and update the program in the database
    private function editProgram()
    {
        $program = Program::find($this->program_id);

        $this->oldValues = $program->getOriginal();

        $program->program_code = $this->program_code;
        $program->program_name = $this->program_name;
        $program->abbreviation = $this->abbreviation;
        $program->program_description = $this->program_description;
        $program->department_id = $this->department_id;

        return $program;
    }

    // Log successful program edit along with changes
    private function logEdit($message, $program, $statusCode)
    {
        session()->flash('success', $message);

        $changes = $this->compareChanges($this->oldValues, $program->getAttributes());

        activity()
            ->performedOn($program)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'success',
                'record_name' => $program->program_name,
                'status_code' => $statusCode,
                'changes' => $changes,
            ])
            ->event('Edit')
            ->log($message);
    }

    // Compare the old and new values to find changes
    private function compareChanges($oldValues, $newValues)
    {
        $changes = [];

        foreach ($oldValues as $key => $oldValue) {
            if (array_key_exists($key, $newValues) && $oldValue !== $newValues[$key]) {
                $changes[$key] = [
                    'old' => $oldValue,
                    'new' => $newValues[$key]
                ];
            }
        }

        return $changes;
    }

    // Log edit error
    private function logEditError($message, $program, $statusCode)
    {
        session()->flash('error', $message);

        activity()
            ->performedOn($program)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'error',
                'record_name' => $program->program_name,
                'status_code' => $statusCode,
            ])
            ->event('Failed Edit')
            ->log($message);
    }

    // Close all modals and reset the form
    public function closeEdit()
    {
        $this->showEditForm = false;
        $this->showEditConfirmation = false;
        $this->resetErrorBag();
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Method for adding course section
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
        return !empty($this->course_id) ||
        !empty($this->year_level) ||
        !empty($this->semester);
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
        $course = new ProgramCourse([
            'course_id' => $this->course_id,
            'year_level' => $this->year_level,
            'semester' => $this->semester,
        ]);
        
        try {

            // Attempt to create the course
            $course = $this->createCourse();

            // Log success and return a success response
            return $this->logAdd('Course successfully added!', $course, 201);

        } catch (ValidationException $e) {
            // Log validation error with the initialized $course
            $errors = $e->validator->errors()->all();
            $errorMessages = implode(' | ', $errors);

            return $this->logAddError('Invalid inputs: ' . $errorMessages, $course, 422);

        } catch (QueryException $e) {
            // Handle duplicate entry error
            if ($e->errorInfo[1] == 1062) {
                return $this->logAddError('Course already added!', $course, 400);
            }

            // Handle other SQL errors
            return $this->logAddError('Database error: ' . $e->getMessage(), $course, 500);
        }
    }

    // Function to create the course entry in the database
    private function createCourse()
    {
        $program = $this->getprogramByUuid($this->uuid);

        // Check for a soft-deleted record with the same `course_id` and `program_id`
        $existingCourse = ProgramCourse::withTrashed()->where([
            'course_id' => $this->course_id,
            'program_id' => $program->program_id,
        ])->first();

        if ($existingCourse) {
            if ($existingCourse->trashed()) {
                // Restore the soft-deleted record
                $existingCourse->restore();
                $existingCourse->update([
                    'year_level' => $this->year_level,
                    'semester' => $this->semester,
                ]);
                return $existingCourse;
            }
        }

        // If no matching record exists, create a new one
        return ProgramCourse::create([
            'course_id' => $this->course_id,
            'year_level' => $this->year_level,
            'semester' => $this->semester,
            'program_id' => $program->program_id,
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
            ->causedBy(Auth::user()) // Associate the logged action with the authenticated user
            ->withProperties([ // Add any additional properties to log
                'status' => 'success', // Mark the status as success
                'record_name' => $course->course_name,  // Log the course name for reference
                'status_code' => $statusCode, // Log the HTTP status code (e.g., 201 for created)
            ])
            ->event('Course Created') // Set the event name as "Course Created"
            ->log($message); // Log the custom success message
    }

    // Function to log an error when course creation fails
    private function logAddError($message, $course, $statusCode)
    {
        // Flash error message to the session for user feedback
        session()->flash('error', $message);
        
        // Log the activity using Spatie Activitylog
        activity()
            ->causedBy(Auth::user()) // Associate the logged action with the authenticated user
            ->withProperties([ // Add any additional properties to log
                'status' => 'error', // Mark the status as error
                'record_name' => $course,  // Log the course name for reference
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
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Method for deleting course section
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
            $course = ProgramCourse::find($this->deleteId);

            if (!$course) {
                return $this->logRemoveError('Course not found!', $course, 404);
            }

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
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'success',  // Status: success
                'record_name' => $course->course->course_name, // Log course name for reference\
                'status_code' => $statusCode
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
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'error',  // Status: error
                'record_name' => $course->course->course_name, // Log course name for reference\
                'status_code' => $statusCode, // HTTP status code (e.g., 400, 422 for failure cases)
            ])
            ->event('Failed to Remove Course') // Event: Failed to Remove Course
            ->log($message); // Log the custom error message
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Method for restoring deleted course
    public function undoDelete()
    {
        // Get the deleted course ID from the session
        $courseId = session()->get('deleted_record_id');

        if ($courseId) {
            try {
                // Retrieve the course including trashed ones
                $course = ProgramCourse::withTrashed()->findOrFail($courseId);

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
            $this->logRestorationError('Course is already active', $course, 409);
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
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'success',
                'record_name' => $course->course->course_name, // Log course name for reference\
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
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'error',
                'record_name' => $course->course->course_name, // Log course name for reference\
                'status_code' => $statusCode,
            ])
            ->event('Restore')
            ->log('Failed to restore course');
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

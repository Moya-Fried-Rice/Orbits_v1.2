<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;

use Livewire\Component;
use App\Models\Program;
use App\Models\Department;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Livewire\WithPagination;

class ProgramCrud extends Component
{
    use WithPagination;

    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Properties
    public $program_code, $program_name, $abbreviation, $program_description, $department_id;
    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;
    public $search = null, $deleteId, $selectedDepartment = null;
    public $sortField = 'created_at', $sortDirection = 'asc';
    
    public function render()
    {
        $programs = Program::query()
            ->selectRaw('programs.*, departments.department_name')
            ->leftJoin('departments', 'programs.department_id', '=', 'departments.department_id') // Join with departments table
            ->when($this->selectedDepartment, function ($query) {
                return $query->where('departments.department_id', $this->selectedDepartment); // Filter by department
            })
            ->when($this->search, function ($query) {
                $query->where('program_name', 'like', '%' . $this->search . '%') // Search by program name
                      ->orWhere('program_code', 'like', '%' . $this->search . '%'); // Search by program code
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(11); // Adjust pagination as needed

        return view('livewire.program-crud', compact('programs'));
    }

    // Validation rules
    protected $rules = [
        'program_code' => 'required|string|max:20',
        'program_name' => 'required|string|max:100',
        'abbreviation' => 'nullable|string|max:10',
        'program_description' => 'nullable|string|max:500',
        'department_id' => 'required|integer|exists:departments,department_id',
    ];

    // Listeners for dispatched events
    protected $listeners = [
        'departmentSelected' => 'departmentFilter',
        'searchPerformed' => 'searchPerformed',
    ];

    // Search Section
    public function searchPerformed($searchTerm)
    {
        $this->search = $searchTerm;
        $this->resetPage();
    }

    // Filter by department
    public function departmentFilter($departmentId)
    {
        $this->selectedDepartment = $departmentId;
        $this->resetPage();
    }

    // Sort programs by field and direction
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

    private function resetInputFields()
    {
        // Reset specific input fields to their initial state
        $this->reset(['program_code', 'program_name', 'abbreviation', 'program_description', 'department_id']);
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
   // Function to show the add program form
    public function add()
    {
        $this->resetErrorBag(); // Reset any validation errors
        $this->resetInputFields(); // Reset all input fields to their initial state
        $this->showAddForm = true; // Show the add form modal for the user to enter data
    }

    // Function to store the program information
    public function store()
    {
        try {
            // Attempt to validate and create the program
            $this->validateQueryStore();
        } catch (Exception $e) {
            // If an unexpected error occurs, log the system error
            $this->logSystemError('An error occurred while storing the program.', $e);
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
        return !empty($this->program_code) ||
            !empty($this->program_name) ||
            !empty($this->abbreviation) ||
            !empty($this->program_description) ||
            !empty($this->department_id);
    }

    // Function that is called if the user confirms to store the program
    public function confirmStore() 
    {
        $this->store(); // Call the store method to save the new program
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->showAddForm = false; // Close the add form modal
        $this->resetInputFields(); // Reset the input fields after storing the program
    }

    // Function that is called if the user cancels the store action
    public function cancelStore() 
    {
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->showAddForm = true; // Show the add form modal again
        $this->resetErrorBag(); // Reset any validation errors
    }

    // Function to validate inputs and handle program creation
    public function validateQueryStore() 
    {
        // Initialize $program with the intended input values
        $program = new Program([
            'program_code' => $this->program_code,
            'program_name' => $this->program_name,
            'abbreviation' => $this->abbreviation,
            'program_description' => $this->program_description,
            'department_id' => $this->department_id,
        ]);

        try {
            // Validate inputs using the $rules property
            $this->validate($this->rules);

            // Attempt to create the program
            $program = $this->createProgram();

            // Log success and return a success response
            return $this->logAdd('Program successfully added!', $program, 201);

        } catch (ValidationException $e) {
            // Log validation error with the initialized $program
            $errors = $e->validator->errors()->all();
            $errorMessages = implode(' | ', $errors);

            return $this->logAddError('Invalid inputs: ' . $errorMessages, $program, 422);
        } catch (QueryException $e) {
            // Handle duplicate entry error
            if ($e->errorInfo[1] == 1062) {
                return $this->logAddError('Program code or name already exists!', $program, 400);
            }

            // Handle other SQL errors
            return $this->logAddError('Database error: ' . $e->getMessage(), $program, 500);
        }
    }

    // Function to create the program entry in the database
    private function createProgram()
    {
        // Check if the program with the same program_code exists (including soft-deleted ones)
        $existingProgram = Program::withTrashed()->where('program_code', $this->program_code)->first();
    
        if ($existingProgram) {
            // If the program is found and is soft-deleted, restore it and update values
            if ($existingProgram->trashed()) {
                $existingProgram->restore(); // Restore the soft-deleted program
                $existingProgram->update([
                    'program_name' => $this->program_name,
                    'abbreviation' => $this->abbreviation,
                    'program_description' => $this->program_description,
                    'department_id' => $this->department_id,
                ]);
                return $existingProgram; // Return the updated program

            }
        } 

        // If no matching program exists, create a new one
        return Program::create([
            'program_code' => $this->program_code,
            'program_name' => $this->program_name,
            'abbreviation' => $this->abbreviation,
            'program_description' => $this->program_description,
            'department_id' => $this->department_id,
        ]);
    
    }
    

    // Function to log a successful program creation
    private function logAdd($message, $program, $statusCode)
    {
        // Flash success message to the session for user feedback
        session()->flash('success', $message);
        
        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($program) // Attach the log to the program object
            ->causedBy(Auth::user()) // Associate the logged action with the authenticated user
            ->withProperties([ // Add any additional properties to log
                'status' => 'success', // Mark the status as success
                'record_name' => $program->program_name,  // Log the program name for reference
                'status_code' => $statusCode, // Log the HTTP status code (e.g., 201 for created)
            ])
            ->event('Program Created') // Set the event name as "Program Created"
            ->log($message); // Log the custom success message
    }

    // Function to log an error when program creation fails
    private function logAddError($message, $program, $statusCode)
    {
        // Flash error message to the session for user feedback
        session()->flash('error', $message);
        
        // Log the activity using Spatie Activitylog
        activity()
            ->causedBy(Auth::user()) // Associate the logged action with the authenticated user
            ->withProperties([ // Add any additional properties to log
                'status' => 'error', // Mark the status as error
                'record_name' => $program,  // Log the program name for reference
                'status_code' => $statusCode, // Log the HTTP status code (e.g., 422 for validation errors)
            ])
            ->event('Failed to Add Program') // Set the event name as "Failed to Add Program"
            ->log($message); // Log the custom error message
    }

    // Function to close the add program form and reset everything
    public function closeAdd() 
    {
        $this->showAddForm = false; // Close the add form modal
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->resetInputFields(); // Reset input fields
        $this->resetErrorBag(); // Reset any validation errors
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
        $this->remove(); // Proceed to delete program from database
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
            $this->logSystemError('An error occurred while deleting the program.', $e);
        } finally {
            session()->forget('deleteId');
        }
    }

    // Validate and process deletion
    public function validateQueryRemove()
    {
        try {
            // Retrieve program by ID
            $program = Program::find($this->deleteId);

            if (!$program) {
                return $this->logRemoveError('Program not found!', $program, 404);
            }

            // Check for related records (dependencies) that prevent deletion
            if ($program->programCourses()->exists()) { 
                return $this->logRemoveError('Cannot delete the program as it has related courses.', $program, 400);
            }

            // Soft delete the program
            $this->deleteProgram($program);

        } catch (QueryException $e) {
            // Handle database query exceptions
            return $this->logRemoveError('Database error: ' . $e->getMessage(), $program, 500);
        }
    }

    // Soft delete the program and log success
    private function deleteProgram($program)
    {
        $program->delete();  // Perform soft delete

        // Log the successful deletion
        return $this->logRemove('Program successfully deleted!', $program, 200);
    }

    // Log successful program removal
    private function logRemove($message, $program, $statusCode)
    {
        // Flash deleted id for restoration to the session
        session()->put('deleted_record_id', $this->deleteId);

        // Flash success message to the session
        session()->flash('deleted', $message);

        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($program)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'success',  // Status: success
                'record_name' => $program->program_name,  // Log the program name for reference
                'status_code' => $statusCode, // HTTP status code (e.g., 200 for successful removal)
            ])
            ->event('Program Removed') // Event: Program Removed
            ->log($message); // Log the custom success message
    }

    // Log an error when program removal fails
    private function logRemoveError($message, $program, $statusCode)
    {
        // Flash error message to the session
        session()->flash('error', $message);

        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($program)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'error',  // Status: error
                'record_name' => $program->program_name,  // Log the program name for reference
                'status_code' => $statusCode, // HTTP status code (e.g., 400, 422 for failure cases)
            ])
            ->event('Failed to Remove Program') // Event: Failed to Remove Program
            ->log($message); // Log the custom error message
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
   // Method for restoring deleted program
    public function undoDelete()
    {
        // Get the deleted program ID from the session
        $programId = session()->get('deleted_record_id');

        if ($programId) {
            try {
                // Retrieve the program including trashed ones
                $program = Program::withTrashed()->findOrFail($programId);

                // Check if the program is already active or needs restoration
                $this->checkIfRestored($program);
            } catch (ModelNotFoundException $e) {
                // Log error if program is not found
                $this->logSystemError('Program not found for restoration!', $e);
            } catch (Exception $e) {
                // Log any other exceptions
                $this->logSystemError('Failed to restore program', $e);
            }
        } else {
            // Handle case where no deleted program is found in session
            session()->flash('error', 'No program available to restore!');
        }
    }

    // Check if the program is already restored
    private function checkIfRestored($program)
    {
        if (!$program->trashed()) {
            // Log if the program is already active
            $this->logRestorationError('Program is already active', $program, 400);
            return;
        } else {
            // Restore the program if it’s trashed
            $this->restoreProgram($program);
        }
    }

    // Restore the program
    private function restoreProgram($program)
    {
        try {
            // Attempt to restore the program
            $program->restore();
            
            // Clear the session for deleted program ID
            session()->forget('deleted_record_id');

            // Log the restoration success
            $this->logRestoration('Program successfully restored!', $program, 200);
        } catch (Exception $e) {
            // Log any errors during the restoration process
            $this->logRestorationError('Failed to restore program', $program, 500);
        }
    }

    // Log the program restoration
    private function logRestoration($message, $program, $statusCode)
    {
        session()->flash('success', $message);

        // Log activity using Spatie Activitylog
        activity()
            ->performedOn($program)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'success',
                'record_name' => $program->program_name,  // Log the program name for reference
                'status_code' => $statusCode,
            ])
            ->event('Restore')
            ->log('Program restored');
    }

    // Log restoration error
    private function logRestorationError($message, $program, $statusCode)
    {
        session()->flash('error', $message);

        // Log activity using Spatie Activitylog
        activity()
            ->performedOn($program)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'error',
                'record_name' => $program->program_name,  // Log the program name for reference
                'status_code' => $statusCode,
            ])
            ->event('Restore')
            ->log('Failed to restore program');
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

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Department;
use Spatie\Activitylog\Traits\LogsActivity;
use Livewire\WithPagination;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DepartmentCrud extends Component
{
    use WithPagination;

    public function render()
    {
        $departments = Department::query()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('department_name', 'like', '%' . $this->search . '%')
                        ->orWhere('department_code', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(11);
    
        return view('livewire.department-crud', compact('departments'));
    }    

    // Public properties for course data and modal states.
    public $department_id, $department_name, $department_description, $department_code;
    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;
    public $search = null, $deleteId;
    public $sortField = 'created_at', $sortDirection = 'asc';    

    protected $listeners = [
        'searchPerformed' => 'searchPerformed'
    ];

    protected $rules = [
        'department_name' => 'required|string|max:255',
        'department_code' => 'required|string|max:50',
        'department_description' => 'nullable|string|max:500',
    ];
    
    public function searchPerformed($searchTerm)
    {
        $this->search = $searchTerm;
        $this->resetPage();
    }

    public function sortBy($field)
    {
        $this->sortField = $this->sortField === $field ? $this->sortField : $field;
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->resetPage();
        $this->dispatch('clearFilters');
    }

    public function clearMessage()
    {
        session()->forget(['success', 'error', 'info', 'deleted']);
    }

    // Method to edit department data ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    public function edit($id)
    {
        $this->resetErrorBag(); // Reset any previous errors

        try {
            // Attempt to find the department by ID
            $department = Department::findOrFail($id);

            // Populate input fields with department data
            $this->department_id = $department->department_id;
            $this->department_name = $department->department_name;
            $this->department_description = $department->department_description;
            $this->department_code = $department->department_code;

            // Show the edit form
            $this->showEditForm = true;
        } catch (ModelNotFoundException $e) {
            // Log error if department is not found
            $this->logSystemError('Department not found', $e);
        } catch (Exception $e) {
            // Log general errors
            $this->logSystemError('Failed to load department', $e);
        }
    }

    // Step 2: Show update confirmation
    public function updateConfirmation()
    {
        // Check if any changes were made
        if (!$this->isDepartmentUpdated()) {
            // If no changes, show a message and return
            session()->flash('info', 'No changes were made to the department.');
            $this->showEditForm = false;
            $this->showEditConfirmation = false;
            return;
        }

        // Close the edit form and show confirmation if there are changes
        $this->showEditForm = false;
        $this->showEditConfirmation = true;
    }

    // Check if the department data has been updated
    private function isDepartmentUpdated()
    {
        $department = Department::find($this->department_id);
        return $department && (
            $department->department_name !== $this->department_name ||
            $department->department_description !== $this->department_description ||
            $department->department_code !== $this->department_code
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

    // Function to update department
    public function update()
    {
        try {
            // Only proceed with the update if changes were made
            if (!$this->isDepartmentUpdated()) {
                session()->flash('info', 'No changes were made to the department.');
                return;
            }

            // Validate and update the department
            $this->validateQueryEdit();
        } catch (Exception $e) {
            // Handle any exceptions during the update process
            $this->logSystemError('An error occurred while updating the department.', $e);
        } finally {
            // Reset input fields after the operation
            $this->resetInputFields();
        }
    }

    // Function to validate inputs and handle department editing
    public function validateQueryEdit()
    {
        // Attempt to edit the department and retrieve the updated department object
        $department = $this->editDepartment();

        try {
            // Validate inputs using defined rules
            $this->validate($this->rules);

            // Save the department changes to the database
            $department->save();

            // Log the successful update along with changes and return a success response
            return $this->logEdit('Department successfully updated!', $department, 200);
        } catch (ValidationException $e) {
            // Handle validation errors (e.g., invalid inputs)
            return $this->logEditError('Invalid inputs!', $department, 422);
        } catch (QueryException $e) {
            // Handle database-related errors
            if ($e->errorInfo[1] == 1062) {
                // Specific error for duplicate department code or name
                return $this->logEditError('Department code or name already exists!', $department, 400);
            }

            // General database error
            return $this->logEditError('Database error: ' . $e->getMessage(), $department, 500);
        }
    }

    // Function to retrieve and update the department in the database
    private function editDepartment()
    {
        // Retrieve the department by its ID
        $department = Department::find($this->department_id);

        // If the department doesn't exist, throw an exception
        if (!$department) {
            throw new ModelNotFoundException('Department not found!');
        }

        // Store old values to log changes later
        $this->oldValues = $department->getOriginal();

        // Update the department properties with new values
        $department->department_name = $this->department_name;
        $department->department_description = $this->department_description;
        $department->department_code = $this->department_code;

        // Return the updated department object
        return $department;
    }

    // Log successful department edit along with changes
    private function logEdit($message, $department, $statusCode)
    {
        // Flash success message to the session
        session()->flash('success', $message);

        // Compare old and new values to log changes
        $changes = $this->compareChanges($this->oldValues, $department->getAttributes());

        // Log the activity
        activity()
            ->performedOn($department)
            ->causedBy(auth()->user())
            ->withProperties([
                'status' => 'success',
                'department_name' => $this->department_name,
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
    private function logEditError($message, $department, $statusCode)
    {
        session()->flash('error', $message); // Flash error message

        activity()
            ->performedOn($department)
            ->causedBy(auth()->user())
            ->withProperties([
                'status' => 'error',
                'department_name' => $this->department_name,
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
        $this->remove(); // Proceed to delete the record from database
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
            $this->logSystemError('An error occurred while deleting the record.', $e);
        } finally {
            session()->forget('deleteId');
        }
    }

    // Validate and process deletion
    public function validateQueryRemove()
    {
        try {
            // Retrieve record by ID
            $record = Department::find($this->deleteId);

            if (!$record) {
                return $this->logRemoveError('Department not found!', $record, 404);
            }

            // Check for related records (dependencies) that prevent deletion
            if ($record->faculty()->exists()) { // Check if there are faculty members linked to the department
                return $this->logRemoveError('Cannot delete the department due to existing faculty members.', $record, 400);
            }

            if ($record->course()->exists()) { // Check if there are courses linked to the department
                return $this->logRemoveError('Cannot delete the department due to existing courses.', $record, 400);
            }

            if ($record->program()->exists()) { // Check if there are programs linked to the department
                return $this->logRemoveError('Cannot delete the department due to existing programs.', $record, 400);
            }

            if ($record->programChair()->exists()) { // Check if there are program chairs linked to the department
                return $this->logRemoveError('Cannot delete the department due to existing program chairs.', $record, 400);
            }

            // Soft delete the record
            $this->deleteRecord($record);

        } catch (QueryException $e) {
            // Handle database query exceptions
            return $this->logRemoveError('Database error: ' . $e->getMessage(), $record, 500);
        }
    }

    // Soft delete the record and log success
    private function deleteRecord($record)
    {
        $record->delete();  // Perform soft delete

        // Log the successful deletion
        return $this->logRemove('Department successfully deleted!', $record, 200);
    }

    // Log successful record removal
    private function logRemove($message, $record, $statusCode)
    {
        // Flash deleted id for restoration to the session
        session()->put('deleted_record_id', $this->deleteId);

        // Flash success message to the session
        session()->flash('deleted', $message);

        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($record)
            ->causedBy(auth()->user())
            ->withProperties([
                'status' => 'success',  // Status: success
                'record_name' => $record->department_name, // Log department name for reference
                'status_code' => $statusCode, // HTTP status code (e.g., 200 for successful removal)
            ])
            ->event('Record Removed') // Event: Record Removed
            ->log($message); // Log the custom success message
    }

    // Log an error when record removal fails
    private function logRemoveError($message, $record, $statusCode)
    {
        // Flash error message to the session
        session()->flash('error', $message);

        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($record)
            ->causedBy(auth()->user())
            ->withProperties([
                'status' => 'error',  // Status: error
                'record_name' => $record->department_name, // Log department name for reference
                'status_code' => $statusCode, // HTTP status code (e.g., 400, 422 for failure cases)
            ])
            ->event('Failed to Remove Record') // Event: Failed to Remove Record
            ->log($message); // Log the custom error message
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑





    // Method for restoring deleted course ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    public function undoDelete()
    {
        // Get the deleted department ID from the session
        $departmentId = session()->get('deleted_record_id');

        if ($departmentId) {
            try {
                // Retrieve the department including trashed ones
                $department = Department::withTrashed()->findOrFail($departmentId);

                // Check if the department is already active or needs restoration
                $this->checkIfRestored($department);
            } catch (ModelNotFoundException $e) {
                // Log error if department is not found
                $this->logSystemError('Department not found for restoration!', $e);
            } catch (Exception $e) {
                // Log any other exceptions
                $this->logSystemError('Failed to restore department', $e);
            }
        } else {
            // Handle case where no deleted department is found in session
            session()->flash('error', 'No department available to restore!');
        }
    }

    // Check if the department is already restored
    private function checkIfRestored($department)
    {
        if (!$department->trashed()) {
            // Log if the department is already active
            $this->logRestorationError('Department is already active', $department);
            return;
        } else {
            // Restore the department if it’s trashed
            $this->restoreDepartment($department);
        }
    }

    // Restore the department
    private function restoreDepartment($department)
    {
        try {
            // Attempt to restore the department
            $department->restore();
            
            // Clear the session for deleted department ID
            session()->forget('deleted_record_id');

            // Log the restoration success
            $this->logRestoration('Department successfully restored!', $department, 200);
        } catch (Exception $e) {
            // Log any errors during the restoration process
            $this->logRestorationError('Failed to restore department', $department, 500);
        }
    }

    // Log the department restoration
    private function logRestoration($message, $department, $statusCode)
    {
        session()->flash('success', $message);

        // Log activity using Spatie Activitylog
        activity()
            ->performedOn($department)
            ->causedBy(auth()->user())
            ->withProperties([
                'status' => 'success',
                'department_name' => $department->department_name,
                'status_code' => $statusCode,
            ])
            ->event('Restore')
            ->log('Department restored');
    }

    // Log restoration error
    private function logRestorationError($message, $department, $statusCode)
    {
        session()->flash('error', $message);

        // Log activity using Spatie Activitylog
        activity()
            ->performedOn($department)
            ->causedBy(auth()->user())
            ->withProperties([
                'status' => 'error',
                'department_name' => $department->department_name,
                'status_code' => $statusCode,
            ])
            ->event('Restore')
            ->log('Failed to restore department');
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑





    // Function to show the add department form ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    public function add()
    {
        $this->resetErrorBag(); // Reset any validation errors
        $this->resetInputFields(); // Reset all input fields to their initial state
        $this->showAddForm = true; // Show the add form modal for the user to enter data
    }

    // Function to store the data
    public function store()
    {
        try {
            // Attempt to validate and create the department
            $this->validateQueryStore();
        } catch (Exception $e) {
            // If an unexpected error occurs, log the system error
            $this->logSystemError('An error occurred while storing the department.', $e);
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

    // Function to check if form is populated
    public function isPopulated()
    {
        return !empty($this->department_name) || !empty($this->department_code);
    }

    // Function that is called if the user confirms to store
    public function confirmStore() 
    {
        $this->store(); // Call the store method to save the new department
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->showAddForm = false; // Close the add form modal
        $this->resetInputFields(); // Reset the input fields after storing the department
    }

    // Function that is called if the user cancels the store action
    public function cancelStore() 
    {
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->showAddForm = true; // Show the add form modal again
        $this->resetErrorBag(); // Reset any validation errors
    }

    // Function to validate inputs and handle department creation
    public function validateQueryStore() 
    {
        // Initialize $department with the intended input values
        $department = new Department([
            'department_name' => $this->department_name,
            'department_code' => $this->department_code,
            'department_description' => $this->department_description,
        ]);

        try {
            // Validate inputs using the $rules property
            $this->validate($this->rules);

            // Attempt to create the department
            $department = $this->createDepartment();

            // Log success and return a success response
            return $this->logAdd('Department successfully added!', $department, 201);

        } catch (ValidationException $e) {
            // Log validation error with the initialized $department
            return $this->logAddError('Invalid inputs!', $department, 422);

        } catch (QueryException $e) {
            // Handle duplicate entry error
            if ($e->errorInfo[1] == 1062) {
                return $this->logAddError('Department code or name already exists!', $department, 400);
            }

            // Handle other SQL errors
            return $this->logAddError('Database error: ' . $e->getMessage(), $department, 500);
        }
    }

    // Function to create the department entry in the database
    private function createDepartment()
    {
        return Department::create([
            'department_name' => $this->department_name,
            'department_code' => $this->department_code,
            'department_description' => $this->department_description,
        ]);
    }

    // Function to log a successful department creation
    private function logAdd($message, $department, $statusCode)
    {
        // Flash success message to the session for user feedback
        session()->flash('success', $message);

        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($department) // Attach the log to the department object
            ->causedBy(auth()->user()) // Associate the logged action with the authenticated user
            ->withProperties([ // Add any additional properties to log
                'status' => 'success', // Mark the status as success
                'department_name' => $this->department_name, // Log the department name for reference
                'status_code' => $statusCode, // Log the HTTP status code (e.g., 201 for created)
            ])
            ->event('Department Created') // Set the event name as "Department Created"
            ->log($message); // Log the custom success message
    }

    // Function to log an error when department creation fails
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
            ->event('Failed to Add Department') // Set the event name as "Failed to Add Department"
            ->log($message); // Log the custom error message
    }

    // Function to close the add department form and reset everything
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
        $this->reset(['department_id', 'department_name', 'department_code', 'department_description']);
    }
}

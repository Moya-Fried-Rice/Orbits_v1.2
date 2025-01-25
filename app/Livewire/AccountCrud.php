<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;

use Livewire\Component;
use App\Models\User;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class AccountCrud extends Component
{
    use WithPagination;

    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Properties
    public $user_id, $name, $role_id, $password, $email;
    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;
    public $search = null, $deleteId, $selectedRole = null;
    public $sortField = 'created_at', $sortDirection = 'asc';
    public $oldValues;

    public function render()
    {
        $accounts = User::query()
            ->leftJoin('roles', 'roles.role_id', '=', 'users.role_id')
            ->select('users.*', 'roles.role_name',)
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('users.name', 'like', '%' . $this->search . '%')
                        ->orWhere('users.email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedRole, fn($query) => $query->where('roles.role_id', $this->selectedRole))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(11);

        return view('livewire.account-crud', compact('accounts'));
    }

    protected $listeners = [
        'searchPerformed' => 'searchPerformed'
    ];

    protected $rules = [
        'user_id' => 'required|integer|exists:users,user_id',
        'email' => 'required|email',
        'password' => 'nullable|min:8',
        'role_id' => 'required|integer|exists:roles,role_id',
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
        $this->selectedRole = '';
        $this->resetPage();
        $this->dispatch('clearFilters');
    }

    public function clearMessage()
    {
        session()->forget(['success', 'error', 'info', 'deleted']);
    }

    private function resetInputFields()
    {
        // Reset specific input fields to their initial state
        $this->reset(['user_id', 'name', 'email', 'role_id', 'password']);
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Method to edit user data
    public function edit($id)
    {
        $this->resetErrorBag();

        try {
            $user = User::findOrFail($id);

            $this->user_id = $user->user_id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->role_id = $user->role_id;

            $this->password = null;
            $this->showEditForm = true;
        } catch (ModelNotFoundException $e) {
            $this
                ->logSystemError('User not found', $e);
        } catch (Exception $e) {
            $this->logSystemError('Failed to load user', $e);
        }
    }

    // Step 2: Show update confirmation
    public function updateConfirmation()
    {
        // Check if any changes were made
        if (!$this->isUpdated()) {
            // If no changes, show a message and return
            session()->flash('info', 'No changes were made to the user.');
            $this->showEditForm = false;
            $this->showEditConfirmation = false;
            return;
        }

        // Close the edit form and show confirmation if there are changes
        $this->showEditForm = false;
        $this->showEditConfirmation = true;
    }

    // Check if the user data has been updated
    private function isUpdated()
    {
        $user = User::find($this->user_id);
        return $user && (
            $user->name !== $this->name ||
            $user->email !== $this->email ||
            $user->role_id !== $this->role_id ||
            ($this->password && !Hash::check($this->password, $user->password))
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

    // Function to update user
    public function update()
    {
        try {
            // Only proceed with the update if changes were made
            if (!$this->isUpdated()) {
                session()->flash('info', 'No changes were made to the user.');
                return;
            }

            // Validate and update the user
            $this->validateQueryEdit();
        } catch (Exception $e) {
            // Handle any exceptions during the update process
            $this->logSystemError('An error occurred while updating the user.', $e);
        } finally {
            // Reset input fields after the operation
            $this->resetInputFields();
        }
    }

    // Function to validate inputs and handle user editing
    public function validateQueryEdit()
    {
        // Attempt to edit the user and retrieve the updated user object
        $user = $this->editUser();

        try {
            // Validate inputs using defined rules
            $this->validate($this->rules);

            // Save the user changes to the database
            $user->save();

            // Log the successful update along with changes and return a success response
            return $this->logEdit('User successfully updated!', $user, 200);
        } catch (ValidationException $e) {
            // Handle validation errors (e.g., invalid inputs)
            $errors = $e->validator->errors()->all();
            $errorMessages = implode(' | ', $errors);

            return $this->logEditError('Invalid inputs: ' . $errorMessages, $user, 422);
        } catch (QueryException $e) {
            // Handle database-related errors
            if ($e->errorInfo[1] == 1062) {
                // Specific error for duplicate email
                return $this->logEditError('Email already exists!', $user, 400);
            }

            // General database error
            return $this->logEditError('Database error: ' . $e->getMessage(), $user, 500);
        }
    }

    // Function to retrieve and update the user in the database
    private function editUser()
    {
        // Retrieve the user by its ID
        $user = User::find($this->user_id);

        // Store old values to log changes later
        $this->oldValues = $user->getOriginal();

        // Update the user properties with new values
        $user->name = $this->name;
        $user->email = $this->email;
        $user->role_id = $this->role_id;

        // Check if password has been changed
        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        // Return the updated user object
        return $user;
    }

    // Log successful user edit along with changes
    private function logEdit($message, $user, $statusCode)
    {
        // Flash success message to the session
        session()->flash('success', $message);

        // Compare old and new values to log changes
        $changes = $this->compareChanges($this->oldValues, $user->getAttributes());

        // Log the activity
        activity()
            ->performedOn($user)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'success',
                'name' => $this->name,
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
    private function logEditError($message, $user, $statusCode)
    {
        session()->flash('error', $message); // Flash error message

        activity()
            ->performedOn($user)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'error',
                'name' => $this->name,
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

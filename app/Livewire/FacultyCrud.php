<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;

use Livewire\Component;
use App\Models\User;
use App\Models\Faculty;
use App\Models\Department;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class FacultyCrud extends Component
{
    use WithPagination, WithFileUploads;

    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Properties
    public $first_name, $last_name, $department_id, $phone_number, $profile_image, $username, $password, $email;
    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;
    public $search = null, $deleteId, $selectedDepartment = null;
    public $sortField = 'created_at', $sortDirection = 'asc';
    
    public function render()
    {
        $faculties = Faculty::query()
            ->selectRaw('faculties.*, CONCAT(faculties.first_name, " ", faculties.last_name) AS full_name, departments.department_name')
            ->leftJoin('departments', 'faculties.department_id', '=', 'departments.department_id') // Join with departments table
            ->when($this->selectedDepartment, function ($query) {
                return $query->where('departments.department_id', $this->selectedDepartment); // Use selectedDepartment for filtering
            })
            ->when($this->search, function ($query) {
                $query->having('full_name', 'like', '%' . $this->search . '%'); // Use HAVING for full_name virtual column filtering
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(11); // Adjust pagination as needed

        return view('livewire.faculty-crud', compact('faculties'));
    }

    // Validation
    protected $rules = [
        'first_name' => 'required|string|max:50',
        'last_name' => 'required|string|max:50',
        'email' => 'required|email',
        'department_id' => 'required|integer|exists:departments,department_id',
        'phone_number' => 'nullable|string|max:15|regex:/^\\+?[0-9]*$/',
        'profile_image' => 'nullable|image|max:2048', // Maximum size of 2MB
    ];

    // Listen to dispatched events
    protected $listeners = [
        'departmentSelected' => 'departmentSearch',
        'searchPerformed' => 'searchPerformed'
    ];

    // Search Section
    public function searchPerformed($searchTerm)
    {
        $this->search = $searchTerm;
        $this->resetPage();
    }

    // Filter section by department
    public function departmentSearch($departmentId)
    {
        $this->selectedDepartment = $departmentId;
        $this->resetPage();
    }

    // Sort faculties by field and direction
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
        $this->reset([
            'first_name',
            'last_name',
            'department_id',
            'phone_number',
            'profile_image',
            'email'
        ]);
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Method to add faculty
    public function add()
    {
        $this->resetErrorBag(); // Reset any validation errors
        $this->resetInputFields(); // Reset all input fields to their initial state
        $this->showAddForm = true; // Show the add form modal for the user to enter data
    }

    // Function to store the faculty information
    public function store()
    {
        try {
            // Attempt to validate and create the faculty
            $this->validateQueryStore();
        } catch (Exception $e) {
            // If an unexpected error occurs, log the system error
            $this->logSystemError('An error occurred while storing the faculty.', $e);
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
        return !empty($this->first_name) ||
            !empty($this->last_name) ||
            !empty($this->department_id) ||
            !empty($this->phone_number) ||
            !empty($this->profile_image) ||
            !empty($this->email); // Include email validation
    }

    // Function that is called if the user confirms to store the faculty
    public function confirmStore() 
    {
        $this->store(); // Call the store method to save the new faculty
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->showAddForm = false; // Close the add form modal
        $this->resetInputFields(); // Reset the input fields after storing the faculty
    }

    // Function that is called if the user cancels the store action
    public function cancelStore() 
    {
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->showAddForm = true; // Show the add form modal again
        $this->resetErrorBag(); // Reset any validation errors
    }

    // Function to validate inputs and handle faculty creation
    public function validateQueryStore() 
    {
        // Initialize $faculty with the intended input values
        $faculty = new Faculty([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'department_id' => $this->department_id,
            'phone_number' => $this->phone_number,
            'profile_image' => $this->profile_image,
        ]);

        try {
            // Validate inputs using the $rules property
            $this->validate($this->rules);

            // Attempt to create the faculty
            $faculty = $this->createFaculty();

            // Log success and return a success response
            return $this->logAdd('Faculty successfully added!', $faculty, 201);

        } catch (ValidationException $e) {
            // Log validation error with the initialized $faculty
            $errors = $e->validator->errors()->all();
            $errorMessages = implode(' | ', $errors);

            return $this->logAddError('Invalid inputs: ' . $errorMessages, $faculty, 422);

        } catch (QueryException $e) {
            // Handle duplicate entry error (e.g., email)
            if ($e->errorInfo[1] == 1062) {
                return $this->logAddError('Email already exists!', $faculty, 400);
            }

            // Handle other SQL errors
            return $this->logAddError('Database error: ' . $e->getMessage(), $faculty, 500);
        }
    }

    // Function to create the faculty entry in the database
    private function createFaculty()
    {
        if ($this->profile_image) {
            $imagePath = $this->profile_image->store('profile_images', 'public');
        } else {
            // If no image is provided, use a default image path
            $imagePath = 'default_images/default_profile.png'; // Provide the path to a default image
        }

        // Ensure a user is created or exists in the `users` table
        $user = User::create([
            'name' => $this->first_name . ' ' . $this->last_name,
            'email' => $this->email, // Assuming email is captured
            'password' => Hash::make('password'), // Use a secure password
            'role_id' => 2, // Assuming role 2 represents Faculty
        ]);

        // Create the faculty record and link it to the user's ID
        return Faculty::create([
            'user_id' => $user->user_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'department_id' => $this->department_id,
            'phone_number' => $this->phone_number,
            'profile_image' => $imagePath,
        ]);
    }

    // Function to log a successful faculty creation
    private function logAdd($message, $faculty, $statusCode)
    {
        // Flash success message to the session for user feedback
        session()->flash('success', $message);

        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($faculty) // Attach the log to the faculty object
            ->causedBy(Auth::user()) // Associate the logged action with the authenticated user
            ->withProperties([ // Add any additional properties to log
                'status' => 'success', // Mark the status as success
                'record_name' => $faculty->first_name . ' ' . $faculty->last_name,  // Log the faculty's first name for reference
                'status_code' => $statusCode, // Log the HTTP status code (e.g., 201 for created)
            ])
            ->event('Faculty Created') // Set the event name as "Faculty Created"
            ->log($message); // Log the custom success message
    }

    // Function to log an error when faculty creation fails
    private function logAddError($message, $faculty, $statusCode)
    {
        // Flash error message to the session for user feedback
        session()->flash('error', $message);

        // Log the activity using Spatie Activitylog
        activity()
            ->causedBy(Auth::user()) // Associate the logged action with the authenticated user
            ->withProperties([ // Add any additional properties to log
                'status' => 'error', // Mark the status as error
                'record_name' => $faculty,
                'status_code' => $statusCode, // Log the HTTP status code (e.g., 422 for validation errors)
            ])
            ->event('Failed to Add Faculty') // Set the event name as "Failed to Add Faculty"
            ->log($message); // Log the custom error message
    }

    // Function to close the add faculty form and reset everything
    public function closeAdd() 
    {
        $this->showAddForm = false; // Close the add form modal
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->resetInputFields(); // Reset input fields
        $this->resetErrorBag(); // Reset any validation errors
    }
     //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Method to delete faculty
    public function delete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteConfirmation = true;
    }

    // Step 2: Confirm/Cancel delete

    // If confirmed
    public function confirmDelete()
    {
        $this->remove(); // Proceed to delete faculty from database
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
            $this->logSystemError('An error occurred while deleting the faculty.', $e);
        } finally {
            session()->forget('deleteId');
        }
    }

    // Validate and process deletion
    public function validateQueryRemove()
    {
        try {
            // Retrieve faculty by ID
            $faculty = Faculty::find($this->deleteId);

            if (!$faculty) {
                return $this->logRemoveError('Faculty not found!', $faculty, 404);
            }

            // Check for related records (dependencies) that prevent deletion
            if ($faculty->facultyCourses()->exists()) { 
                return $this->logRemoveError('Cannot delete the faculty as they are currently assigned with a course.', $faculty, 400);
            }

            // Soft delete the faculty
            $this->deleteFaculty($faculty);

        } catch (QueryException $e) {
            // Handle database query exceptions
            return $this->logRemoveError('Database error: ' . $e->getMessage(), $faculty, 500);
        }
    }

    // Soft delete the faculty and log success
    private function deleteFaculty($faculty)
    {
        $faculty->delete();  // Perform soft delete

        // Log the successful deletion
        return $this->logRemove('Faculty successfully deleted!', $faculty, 200);

        return redirect()->route('faculties');
    }

    // Log successful faculty removal
    private function logRemove($message, $faculty, $statusCode)
    {
        // Flash deleted id for restoration to the session
        session()->put('deleted_record_id', $this->deleteId);

        // Flash success message to the session
        session()->flash('deleted', $message);

        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($faculty)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'success',  // Status: success
                'record_name' => $faculty->first_name . ' ' . $faculty->last_name, // Log faculty name for reference
                'status_code' => $statusCode, // HTTP status code (e.g., 200 for successful removal)
            ])
            ->event('Faculty Removed') // Event: Faculty Removed
            ->log($message); // Log the custom success message
    }

    // Log an error when faculty removal fails
    private function logRemoveError($message, $faculty, $statusCode)
    {
        // Flash error message to the session
        session()->flash('error', $message);

        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($faculty)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'error',  // Status: error
                'faculty_name' => $faculty->first_name . ' ' . $faculty->last_name, // Log faculty name for reference
                'status_code' => $statusCode, // HTTP status code (e.g., 400, 422 for failure cases)
            ])
            ->event('Failed to Remove Faculty') // Event: Failed to Remove Faculty
            ->log($message); // Log the custom error message
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Method for restoring deleted faculty
    public function undoDelete()
    {
        // Get the deleted faculty ID from the session
        $facultyId = session()->get('deleted_record_id');

        if ($facultyId) {
            try {
                // Retrieve the faculty including trashed ones
                $faculty = Faculty::withTrashed()->findOrFail($facultyId);

                // Check if the faculty is already active or needs restoration
                $this->checkIfRestored($faculty);
            } catch (ModelNotFoundException $e) {
                // Log error if faculty is not found
                $this->logSystemError('Faculty not found for restoration!', $e);
            } catch (Exception $e) {
                // Log any other exceptions
                $this->logSystemError('Failed to restore faculty', $e);
            }
        } else {
            // Handle case where no deleted faculty is found in session
            session()->flash('error', 'No faculty available to restore!');
        }
    }

    // Check if the faculty is already restored
    private function checkIfRestored($faculty)
    {
        if (!$faculty->trashed()) {
            // Log if the faculty is already active
            $this->logRestorationError('Faculty is already active', $faculty, 400);
            return;
        } else {
            // Restore the faculty if they are trashed
            $this->restoreFaculty($faculty);
        }
    }

    // Restore the faculty
    private function restoreFaculty($faculty)
    {
        try {
            // Attempt to restore the faculty
            $faculty->restore();
            
            // Clear the session for deleted faculty ID
            session()->forget('deleted_record_id');

            // Log the restoration success
            $this->logRestoration('Faculty successfully restored!', $faculty, 200);
        } catch (Exception $e) {
            // Log any errors during the restoration process
            $this->logRestorationError('Failed to restore faculty', $faculty, 500);
        }
    }

    // Log the faculty restoration
    private function logRestoration($message, $faculty, $statusCode)
    {
        session()->flash('success', $message);

        // Log activity using Spatie Activitylog
        activity()
            ->performedOn($faculty)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'success',
                'record_name' => $faculty->first_name . ' ' . $faculty->last_name,
                'status_code' => $statusCode,
            ])
            ->event('Restore')
            ->log('Faculty restored');
    }

    // Log restoration error
    private function logRestorationError($message, $faculty, $statusCode)
    {
        session()->flash('error', $message);

        // Log activity using Spatie Activitylog
        activity()
            ->performedOn($faculty)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'error',
                'record_name' => $faculty->first_name . ' ' . $faculty->last_name,
                'status_code' => $statusCode,
            ])
            ->event('Restore')
            ->log('Failed to restore faculty');
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

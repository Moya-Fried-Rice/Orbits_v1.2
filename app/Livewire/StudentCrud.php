<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;

use Livewire\Component;
use App\Models\User;
use App\Models\Student;
use App\Models\Department;
use App\Models\Program;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class StudentCrud extends Component
{
    use WithPagination;
    use WithFileUploads;

    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Properties
    public $first_name, $last_name, $program_id, $phone_number, $profile_image, $email;
    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;
    public $search = null, $deleteId, $selectedProgram = null;
    public $sortField = 'created_at', $sortDirection = 'asc';

    public function render()
    {
        $students = Student::query()
            ->selectRaw('students.*, CONCAT(students.first_name, " ", students.last_name) AS full_name, programs.program_code')
            ->leftJoin('programs', 'students.program_id', '=', 'programs.program_id')
            ->when($this->selectedProgram, function ($query) {
                return $query->where('programs.program_id', $this->selectedProgram);
            })
            ->when($this->search, function ($query) {
                $query->having('full_name', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(11);

        return view('livewire.student-crud', compact('students'));
    }

    // Validation
    protected $rules = [
        'first_name' => 'required|string|max:50',
        'last_name' => 'required|string|max:50',
        'program_id' => 'required|integer|exists:programs,program_id',
        'phone_number' => 'nullable|string|max:15|regex:/^\+?[0-9]*$/',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ];

    // Listen to dispatched events
    protected $listeners = [
        'programSelected' => 'programSearch',
        'searchPerformed' => 'searchPerformed'
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

    // Reset specific input fields to their initial state
    private function resetInputFields()
    {
        $this->reset([
            'first_name',
            'last_name',
            'program_id',
            'phone_number',
            'profile_image',
            'email'
        ]);
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Method to add student
    public function add()
    {
        $this->resetErrorBag(); // Reset any validation errors
        $this->resetInputFields(); // Reset all input fields to their initial state
        $this->showAddForm = true; // Show the add form modal for the user to enter data
    }

    // Function to store the student information
    public function store()
    {
        try {
            // Attempt to validate and create the student
            $this->validateQueryStore();
        } catch (Exception $e) {
            // If an unexpected error occurs, log the system error
            $this->logSystemError('An error occurred while storing the student.', $e);
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
            !empty($this->program_id) ||
            !empty($this->phone_number) ||
            !empty($this->profile_image);
    }

    // Function that is called if the user confirms to store the student
    public function confirmStore() 
    {
        $this->store(); // Call the store method to save the new student
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->showAddForm = false; // Close the add form modal
        $this->resetInputFields(); // Reset the input fields after storing the student
    }

    // Function that is called if the user cancels the store action
    public function cancelStore() 
    {
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->showAddForm = true; // Show the add form modal again
        $this->resetErrorBag(); // Reset any validation errors
    }

    // Function to validate inputs and handle student creation
    public function validateQueryStore() 
    {
        // Initialize $student with the intended input values
        $student = new Student([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'program_id' => $this->program_id,
            'phone_number' => $this->phone_number,
            'profile_image' => $this->profile_image,
        ]);

        try {
            // Validate inputs using the $rules property
            $this->validate($this->rules);

            // Attempt to create the student
            $student = $this->createStudent();

            // Log success and return a success response
            return $this->logAdd('Student successfully added!', $student, 201);

        } catch (ValidationException $e) {
            // Log validation error with the initialized $student
            $errors = $e->validator->errors()->all();
            $errorMessages = implode(' | ', $errors);

            return $this->logAddError('Invalid inputs: ' . $errorMessages, $student, 422);

        } catch (QueryException $e) {
            // Handle duplicate entry error
            if ($e->errorInfo[1] == 1062) {
                return $this->logAddError('Email already exists!', $student, 400);
            }

            // Handle other SQL errors
            return $this->logAddError('Database error: ' . $e->getMessage(), $student, 500);
        }
    }

    // Function to create the student entry in the database
    private function createStudent()
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
            'role' => 1,
        ]);

        // Create the student record and link it to the user's ID
        return Student::create([
            'user_id' => $user->user_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'program_id' => $this->program_id,
            'phone_number' => $this->phone_number,
            'profile_image' => $imagePath,
        ]);
    }

    // Function to log a successful student creation
    private function logAdd($message, $student, $statusCode)
    {
        // Flash success message to the session for user feedback
        session()->flash('success', $message);
        
        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($student) // Attach the log to the student object
            ->causedBy(Auth::user()) // Associate the logged action with the authenticated user
            ->withProperties([ // Add any additional properties to log
                'status' => 'success', // Mark the status as success
                'first_name' => $this->first_name,  // Log the student's first name for reference
                'last_name' => $this->last_name,  // Log the student's last name for reference
                'status_code' => $statusCode, // Log the HTTP status code (e.g., 201 for created)
            ])
            ->event('Student Created') // Set the event name as "Student Created"
            ->log($message); // Log the custom success message
    }

    // Function to log an error when student creation fails
    private function logAddError($message, $statusCode)
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
            ->event('Failed to Add Student') // Set the event name as "Failed to Add Student"
            ->log($message); // Log the custom error message
    }

    // Function to close the add student form and reset everything
    public function closeAdd() 
    {
        $this->showAddForm = false; // Close the add form modal
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->resetInputFields(); // Reset input fields
        $this->resetErrorBag(); // Reset any validation errors
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Method to delete student
    public function delete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteConfirmation = true;
    }
    
    // Step 2: Confirm/Cancel delete
    
    // If confirmed
    public function confirmDelete()
    {
        $this->remove(); // Proceed to delete student from database
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
            $this->logSystemError('An error occurred while deleting the student.', $e);
        } finally {
            session()->forget('deleteId');
        }
    }
    
    // Validate and process deletion
    public function validateQueryRemove()
    {
        try {
            // Retrieve student by ID
            $student = Student::find($this->deleteId);
    
            if (!$student) {
                return $this->logRemoveError('Student not found!', $student, 404);
            }
    
            // Check for related records (dependencies) that prevent deletion
            if ($student->studentCourse()->exists()) { 
                return $this->logRemoveError('Cannot delete the student as they are currently enrolled in a course.', $student, 400);
            }
    
            // Soft delete the student
            $this->deleteStudent($student);

        } catch (QueryException $e) {
            // Handle database query exceptions
            return $this->logRemoveError('Database error: ' . $e->getMessage(), $student, 500);
        }
    }
    
    // Soft delete the student and log success
    private function deleteStudent($student)
    {
        $student->delete();  // Perform soft delete

        // Log the successful deletion
        return $this->logRemove('Student successfully deleted!', $student, 200);

        return redirect()->route('students');
    }
    
    // Log successful student removal
    private function logRemove($message, $student, $statusCode)
    {
        // Flash deleted id for restoration to the session
        session()->put('deleted_record_id', $this->deleteId);
    
        // Flash success message to the session
        session()->flash('deleted', $message);
    
        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($student)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'success',  // Status: success
                'student_name' => $student->first_name . ' ' . $student->last_name, // Log student name for reference
                'status_code' => $statusCode, // HTTP status code (e.g., 200 for successful removal)
            ])
            ->event('Student Removed') // Event: Student Removed
            ->log($message); // Log the custom success message
    }
    
    // Log an error when student removal fails
    private function logRemoveError($message, $student, $statusCode)
    {
        // Flash error message to the session
        session()->flash('error', $message);
    
        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($student)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'error',  // Status: error
                'student_name' => $student->first_name . ' ' . $student->last_name, // Log student name for reference
                'status_code' => $statusCode, // HTTP status code (e.g., 400, 422 for failure cases)
            ])
            ->event('Failed to Remove Student') // Event: Failed to Remove Student
            ->log($message); // Log the custom error message
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Method for restoring deleted student
    public function undoDelete()
    {
        // Get the deleted student ID from the session
        $studentId = session()->get('deleted_record_id');

        if ($studentId) {
            try {
                // Retrieve the student including trashed ones
                $student = Student::withTrashed()->findOrFail($studentId);

                // Check if the student is already active or needs restoration
                $this->checkIfRestored($student);
            } catch (ModelNotFoundException $e) {
                // Log error if student is not found
                $this->logSystemError('Student not found for restoration!', $e);
            } catch (Exception $e) {
                // Log any other exceptions
                $this->logSystemError('Failed to restore student', $e);
            }
        } else {
            // Handle case where no deleted student is found in session
            session()->flash('error', 'No student available to restore!');
        }
    }

    // Check if the student is already restored
    private function checkIfRestored($student)
    {
        if (!$student->trashed()) {
            // Log if the student is already active
            $this->logRestorationError('Student is already active', $student, 400);
            return;
        } else {
            // Restore the student if they are trashed
            $this->restoreStudent($student);
        }
    }

    // Restore the student
    private function restoreStudent($student)
    {
        try {
            // Attempt to restore the student
            $student->restore();
            
            // Clear the session for deleted student ID
            session()->forget('deleted_record_id');

            // Log the restoration success
            $this->logRestoration('Student successfully restored!', $student, 200);
        } catch (Exception $e) {
            // Log any errors during the restoration process
            $this->logRestorationError('Failed to restore student', $student, 500);
        }
    }

    // Log the student restoration
    private function logRestoration($message, $student, $statusCode)
    {
        session()->flash('success', $message);

        // Log activity using Spatie Activitylog
        activity()
            ->performedOn($student)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'success',
                'student_name' => $student->student_name,
                'status_code' => $statusCode,
            ])
            ->event('Restore')
            ->log('Student restored');
    }

    // Log restoration error
    private function logRestorationError($message, $student, $statusCode)
    {
        session()->flash('error', $message);

        // Log activity using Spatie Activitylog
        activity()
            ->performedOn($student)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'error',
                'student_name' => $student->student_name,
                'status_code' => $statusCode,
            ])
            ->event('Restore')
            ->log('Failed to restore student');
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

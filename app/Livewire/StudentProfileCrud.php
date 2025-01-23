<?php

namespace App\Livewire;
use Livewire\Component;
use App\Models\User;
use App\Models\Student;
use App\Models\Department;
use App\Models\Program;
use Spatie\Activitylog\Traits\LogsActivity;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;

class StudentProfileCrud extends Component
{
    use WithFileUploads;

    public $uuid;

    public function render()
    {
        $uuid = $this->uuid; // Ensure the $uuid variable is defined

        // Eager load the course sections for the student
        $student = Student::with('courseSections')->where('uuid', $uuid)->first();

        return view('livewire.student-profile-crud', compact('student'));
    }


    // Public properties for course data and modal states.
    public $student_id, $first_name, $last_name, $program_id, $phone_number, $profile_image, $email;
    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;
    public $search = null, $deleteId, $selectedProgram = null;
    public $sortField = 'created_at', $sortDirection = 'asc';

    // Validation
    protected $rules = [
        'first_name' => 'required|string|max:50',
        'last_name' => 'required|string|max:50',
        'program_id' => 'required|integer|exists:programs,program_id',
        'phone_number' => 'nullable|string|max:20|regex:/^(\+?\d{1,3})?[\s\-\.]?(\(\d{1,4}\)[\s\-\.]?)?\d{1,4}[\s\-\.]?\d{1,4}[\s\-\.]?\d{1,9}$/',
        'profile_image' => 'nullable|max:2048', // Maximum size of 2MB
    ];

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


    // Method to edit student data
    public function edit($id)
    {
        $this->resetErrorBag(); // Reset any previous errors

        try {
            // Attempt to find the student by ID
            $student = Student::findOrFail($id);

            // Populate input fields with student data
            $this->student_id = $student->student_id;
            $this->first_name = $student->first_name;
            $this->last_name = $student->last_name;
            $this->program_id = $student->program_id;
            $this->phone_number = $student->phone_number;
            $this->profile_image = $student->profile_image;

            // Show the edit form
            $this->showEditForm = true;
        } catch (ModelNotFoundException $e) {
            // Log error if student is not found
            $this->logSystemError('Student not found', $e);
        } catch (Exception $e) {
            // Log general errors
            $this->logSystemError('Failed to load student', $e);
        }
    }

    // Step 2: Show update confirmation
    public function updateConfirmation()
    {
        // Check if any changes were made
        if (!$this->isUpdated()) {
            // If no changes, show a message and return
            session()->flash('info', 'No changes were made to the student.');
            $this->showEditForm = false;
            $this->showEditConfirmation = false;
            return;
        }

        // Close the edit form and show confirmation if there are changes
        $this->showEditForm = false;
        $this->showEditConfirmation = true;
    }

    // Check if the student data has been updated
    private function isUpdated()
    {
        $student = Student::find($this->student_id);
        return $student && (
            $student->first_name !== $this->first_name ||
            $student->last_name !== $this->last_name ||
            $student->program_id !== $this->program_id ||
            $student->phone_number !== $this->phone_number || 
            $student->profile_image !== $this->profile_image
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

    // Function to update student
    public function update()
    {
        try {
            // Only proceed with the update if changes were made
            if (!$this->isUpdated()) {
                session()->flash('info', 'No changes were made to the student.');
                return;
            }

            // Validate and update the student
            $this->validateQueryEdit();
        } catch (Exception $e) {
            // Handle any exceptions during the update process
            $this->logSystemError('An error occurred while updating the student.', $e);
        } finally {
            // Reset input fields after the operation
            $this->resetInputFields();
        }
    }

    // Function to validate inputs and handle student editing
    public function validateQueryEdit()
    {
        // Attempt to edit the student and retrieve the updated student object
        $student = $this->editStudent();

        try {
            // Validate inputs using defined rules
            $this->validate($this->rules);

            // Save the student changes to the database
            $student->save();

            // Log the successful update along with changes and return a success response
            return $this->logEdit('Student successfully updated!', $student, 200);
        } catch (ValidationException $e) {
            // Handle validation errors (e.g., invalid inputs)
            return $this->logEditError('Invalid inputs!' . $e, $student, 422);
        } catch (QueryException $e) {
            // Handle database-related errors
            if ($e->errorInfo[1] == 1062) {
                // Specific error for duplicate phone number or other unique fields
                return $this->logEditError('Duplicate entry found!', $student, 400);
            }

            // General database error
            return $this->logEditError('Database error: ' . $e->getMessage(), $student, 500);
        }
    }

    // Function to retrieve and update the student in the database
    private function editStudent()
    {
        // Retrieve the student by its ID
        $student = Student::find($this->student_id);

        // If the student doesn't exist, throw an exception
        if (!$student) {
            throw new ModelNotFoundException('Student not found!');
        }

        // Store old values to log changes later
        $this->oldValues = $student->getOriginal();

        // Update the student properties with new values
        $student->first_name = $this->first_name;
        $student->last_name = $this->last_name;
        $student->program_id = $this->program_id;
        $student->phone_number = $this->phone_number;
        
        if ($this->profile_image instanceof UploadedFile) {
            $imagePath = $this->validateAndStoreImage($this->profile_image);
            $student->profile_image = $imagePath;
        }

        // Return the updated student object
        return $student;
    }

    private function validateAndStoreImage(UploadedFile $file)
    {
        // Validate the file type
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
            throw new \Exception('Invalid file type. Allowed types are: jpeg, png, jpg, gif, webp.');
        }

        // Store the image
        return $file->store('profile_images', 'public');
    }

    // Log successful student edit along with changes
    private function logEdit($message, $student, $statusCode)
    {
        // Flash success message to the session
        session()->flash('success', $message);

        // Compare old and new values to log changes
        $changes = $this->compareChanges($this->oldValues, $student->getAttributes());

        // Log the activity
        activity()
            ->performedOn($student)
            ->causedBy(auth()->user())
            ->withProperties([
                'status' => 'success',
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
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
    private function logEditError($message, $student, $statusCode)
    {
        session()->flash('error', $message); // Flash error message

        activity()
            ->performedOn($student)
            ->causedBy(auth()->user())
            ->withProperties([
                'status' => 'error',
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
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

    private function resetInputFields()
    {
        // Reset specific input fields to their initial state
        $this->reset([
            'first_name',
            'last_name',
            'program_id',
            'phone_number',
            'profile_image',
            'email'
        ]);
    }
}

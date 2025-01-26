<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;

use Livewire\Component;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Section;
use App\Models\FacultyCourse;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;

class FacultyProfileCrud extends Component
{
    use WithFileUploads;

    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Properties
    public $uuid;
    public $faculty_id, $first_name, $last_name, $department_id, $phone_number, $profile_image, $email;
    public $course_section_id, $facultyCourse;
    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;
    public $deleteId;
    private $oldValues;

    public function render()
    {
        // Retrieve the faculty data based on the provided UUID
        $faculty = $this->getFacultyByUuid($this->uuid);

        // Render the view with the faculty data
        return view('livewire.faculty-profile-crud', compact('faculty'));
    }

    // Function to get faculty details by UUID, including associated department
    protected function getFacultyByUuid($uuid)
    {
        // Return the faculty record along with its associated department
        return Faculty::with('facultyCourse')->where('uuid', $uuid)->first();
    }

    // Validation rules for updating faculty profile
    protected $rules = [
        'first_name' => 'required|string|max:50',
        'last_name' => 'required|string|max:50',
        'department_id' => 'required|integer|exists:departments,department_id',
        'phone_number' => 'nullable|string|max:20|regex:/^(\+?\d{1,3})?[\s\-\.]?(\(\d{1,4}\)[\s\-\.]?)?\d{1,4}[\s\-\.]?\d{1,4}[\s\-\.]?\d{1,9}$/',
        'profile_image' => 'nullable|max:1024',
    ];

    public function getDepartments()
    {
        // Retrieve all departments
        return Department::all();
    }

    public function getSections()
    {
        // Get the student by UUID to find the department ID
        $faculty = $this->getfacultyByUuid($this->uuid);
        $departmentId = $faculty->department_id;

        // Retrieve sections related to the faculty's program
        return Section::whereHas('courseSection.course', function ($query) use ($departmentId) {
            $query->where('courses.department_id', $departmentId); // Filter sections based on the program ID
        })->get();
    }

    public function clearMessage()
    {
        // Clear any session messages such as success, error, or info
        session()->forget(['success', 'error', 'info', 'deleted']);
    }

    private function resetInputFields()
    {
        // Reset all form input fields to their initial values
        $this->reset([
            'first_name',
            'last_name',
            'department_id',
            'phone_number',
            'profile_image',
            'email',
            'course_section_id'
        ]);
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Method to edit faculty data
    public function edit($id)
    {
        $this->resetErrorBag();

        try {
            $faculty = Faculty::findOrFail($id);

            // Populate input fields with faculty data
            $this->faculty_id = $faculty->faculty_id;
            $this->first_name = $faculty->first_name;
            $this->last_name = $faculty->last_name;
            $this->department_id = $faculty->department_id;
            $this->phone_number = $faculty->phone_number;
            $this->profile_image = $faculty->profile_image;

            // Show the edit form
            $this->showEditForm = true;
        } catch (ModelNotFoundException $e) {
            // Log error if faculty is not found
            $this->logSystemError('Faculty not found', $e);
        } catch (Exception $e) {
            // Log general errors
            $this->logSystemError('Failed to load faculty', $e);
        }
    }

    // Step 2: Show update confirmation
    public function updateConfirmation()
    {
        // Check if any changes were made
        if (!$this->isUpdated()) {
            // If no changes, show a message and return
            session()->flash('info', 'No changes were made to the faculty.');
            $this->showEditForm = false;
            $this->showEditConfirmation = false;
            return;
        }

        // Close the edit form and show confirmation if there are changes
        $this->showEditForm = false;
        $this->showEditConfirmation = true;
    }

    // Check if the faculty data has been updated
    private function isUpdated()
    {
        $faculty = Faculty::find($this->faculty_id);
        return $faculty && (
            $faculty->first_name !== $this->first_name ||
            $faculty->last_name !== $this->last_name ||
            $faculty->department_id != $this->department_id ||
            $faculty->phone_number !== $this->phone_number || 
            $faculty->profile_image !== $this->profile_image
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

    // Function to update faculty
    public function update()
    {
        try {
            // Only proceed with the update if changes were made
            if (!$this->isUpdated()) {
                session()->flash('info', 'No changes were made to the faculty.');
                return;
            }

            // Validate and update the faculty
            $this->validateQueryEdit();
        } catch (Exception $e) {
            // Handle any exceptions during the update process
            $this->logSystemError('An error occurred while updating the faculty.', $e);
        } finally {
            // Reset input fields after the operation
            $this->resetInputFields();
        }
    }

    // Function to validate inputs and handle faculty editing
    public function validateQueryEdit()
    {
        // Attempt to edit the faculty and retrieve the updated faculty object
        $faculty = $this->editFaculty();

        try {
            // Validate inputs using defined rules
            $this->validate($this->rules);

            // Save the faculty changes to the database
            $faculty->save();

            // Log the successful update along with changes and return a success response
            return $this->logEdit('Faculty successfully updated!', $faculty, 200);
        } catch (ValidationException $e) {
            // Handle validation errors (e.g., invalid inputs)
            $errors = $e->validator->errors()->all();
            $errorMessages = implode(' | ', $errors);

            return $this->logEditError('Invalid inputs: ' . $errorMessages, $faculty, 422);
        } catch (QueryException $e) {
            // Handle database-related errors
            if ($e->errorInfo[1] == 1062) {
                // Specific error for duplicate phone number or other unique fields
                return $this->logEditError('Duplicate entry found!', $faculty, 400);
            }

            // General database error
            return $this->logEditError('Database error: ' . $e->getMessage(), $faculty, 500);
        }
    }

    // Function to retrieve and update the faculty in the database
    private function editFaculty()
    {
        // Retrieve the faculty by its ID
        $faculty = Faculty::find($this->faculty_id);

        // Store old values to log changes later
        $this->oldValues = $faculty->getOriginal();

        // Update the faculty properties with new values
        $faculty->first_name = $this->first_name;
        $faculty->last_name = $this->last_name;
        $faculty->department_id = $this->department_id;
        $faculty->phone_number = $this->phone_number;
        
        if ($this->profile_image instanceof UploadedFile) {
            $imagePath = $this->validateAndStoreImage($this->profile_image);
            $faculty->profile_image = $imagePath;
        }

        // Return the updated faculty object
        return $faculty;
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

    // Log successful faculty edit along with changes
    private function logEdit($message, $faculty, $statusCode)
    {
        // Flash success message to the session
        session()->flash('success', $message);

        // Compare old and new values to log changes
        $changes = $this->compareChanges($this->oldValues, $faculty->getAttributes());

        // Log the activity
        activity()
            ->performedOn($faculty)
            ->causedBy(Auth::user())
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
    private function logEditError($message, $faculty, $statusCode)
    {
        session()->flash('error', $message); // Flash error message

        activity()
            ->performedOn($faculty)
            ->causedBy(Auth::user())
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
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
   // Method for adding faculty course
    public function add()
    {
        $this->resetErrorBag(); // Reset any validation errors
        $this->resetInputFields(); // Reset all input fields to their initial state
        $this->showAddForm = true; // Show the add faculty course form modal for the user to enter data
    }

    // Function to store the faculty course information
    public function store()
    {
        try {
            // Attempt to validate and create the faculty course
            $this->validateQueryStore();
        } catch (Exception $e) {
            // If an unexpected error occurs, log the system error
            $this->logSystemError('An error occurred while storing the faculty course.', $e);
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
        return !empty($this->course_section_id); // Check if faculty_course_id is populated
    }

    // Function that is called if the user confirms to store the faculty course
    public function confirmStore() 
    {
        $this->store(); // Call the store method to save the new faculty course
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->showAddForm = false; // Close the add form modal
        $this->resetInputFields(); // Reset the input fields after storing the faculty course
    }

    // Function that is called if the user cancels the store action
    public function cancelStore() 
    {
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->showAddForm = true; // Show the add form modal again
        $this->resetErrorBag(); // Reset any validation errors
    }

    // Function to validate inputs and handle faculty course creation
    public function validateQueryStore() 
    {
        // Initialize $facultyCourse with the intended input values
        $facultyCourse = new FacultyCourse([
            'course_section_id' => $this->course_section_id,
        ]);
        
        try {
            // Attempt to create the faculty course
            $facultyCourse = $this->createFacultyCourse();

            // Log success and return a success response
            return $this->logAdd('Faculty Course successfully added!', $facultyCourse, 201);

        } catch (ValidationException $e) {
            // Log validation error with the initialized $facultyCourse
            $errors = $e->validator->errors()->all();
            $errorMessages = implode(' | ', $errors);

            return $this->logAddError('Invalid inputs: ' . $errorMessages, $facultyCourse, 422);

        } catch (QueryException $e) {
            // Handle duplicate entry error
            if ($e->errorInfo[1] == 1062) {
                return $this->logAddError('Faculty already assigned to the course!', $facultyCourse, 400);
            }

            // Handle other SQL errors
            return $this->logAddError('Database error: ' . $e->getMessage(), $facultyCourse, 500);
        }
    }

    // Function to create the faculty course entry in the database
    private function createFacultyCourse()
    {
        $faculty = $this->getFacultyByUuid($this->uuid);
    
        // Check for a soft-deleted record with the same `course_section_id`
        $existingFacultyCourse = FacultyCourse::withTrashed()->where('course_section_id', $this->course_section_id)->first();
    
        if ($existingFacultyCourse) {
            if ($existingFacultyCourse->trashed()) {
                // Restore the soft-deleted record and update the faculty_id
                $existingFacultyCourse->restore();
                $existingFacultyCourse->update(['faculty_id' => $faculty->faculty_id]);
                return $existingFacultyCourse;
            } 
        }
    
        // If no matching record exists, create a new one
        return FacultyCourse::create([
            'course_section_id' => $this->course_section_id,
            'faculty_id' => $faculty->faculty_id,
        ]);
    }    

    // Function to log a successful faculty course creation
    private function logAdd($message, $facultyCourse, $statusCode)
    {
        // Flash success message to the session for user feedback
        session()->flash('success', $message);
        
        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($facultyCourse) // Attach the log to the faculty course object
            ->causedBy(Auth::user()) // Associate the logged action with the authenticated user
            ->withProperties([ // Add any additional properties to log
                'status' => 'success', // Mark the status as success
                'course_section_id' => $this->course_section_id, // Log the course section ID for reference
                'status_code' => $statusCode, // Log the HTTP status code (e.g., 201 for created)
            ])
            ->event('Faculty Course Created') // Set the event name as "Faculty Course Created"
            ->log($message); // Log the custom success message
    }

    // Function to log an error when faculty course creation fails
    private function logAddError($message, $facultyCourse, $statusCode)
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
            ->event('Failed to Add Faculty Course') // Set the event name as "Failed to Add Faculty Course"
            ->log($message); // Log the custom error message
    }

    // Function to close the add faculty course form and reset everything
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
            $course = FacultyCourse::find($this->deleteId);

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
                'faculty_course' => $course->courseSection->section->section_code, // Log course name for reference\
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
                'faculty_course' => $course->courseSection->section->section_code, // Log course name for reference\
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
                $course = FacultyCourse::withTrashed()->findOrFail($courseId);

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
                'faculty_course' => $course->courseSection->section->section_code,
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
                'faculty_course' => $course->courseSection->section->section_code,
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

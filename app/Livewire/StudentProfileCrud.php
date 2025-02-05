<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;

use Livewire\Component;
use App\Models\Student;
use App\Models\Department;
use App\Models\CourseSection;
use App\Models\StudentCourse;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;

class StudentProfileCrud extends Component
{
    use WithFileUploads;

    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Properties
    public $uuid;
    public $student_id, $first_name, $last_name, $program_id, $phone_number, $profile_image, $email;
    public $course_section_id, $studentCourse;
    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;
    public $deleteId;
    private $oldValues;

    public function render()
    {
        // Retrieve the student data based on the provided UUID
        $student = $this->getStudentByUuid($this->uuid);

        // Render the view with the student data
        return view('livewire.student-profile-crud', compact('student'));
    }

    // Function to get student details by UUID, including associated course sections
    protected function getStudentByUuid($uuid)
    {
        // Return the student record along with its associated course section
        return Student::with('studentCourses.courseSection')->where('uuid', $uuid)->first();
    }

    // Validation rules for updating student profile
    protected $rules = [
        'first_name' => 'required|string|max:50',
        'last_name' => 'required|string|max:50',
        'program_id' => 'required|integer|exists:programs,program_id',
        'phone_number' => 'nullable|string|max:20|regex:/^(\+?\d{1,3})?[\s\-\.]?(\(\d{1,4}\)[\s\-\.]?)?\d{1,4}[\s\-\.]?\d{1,4}[\s\-\.]?\d{1,9}$/',
        'profile_image' => 'nullable|max:1024', 
    ];

    public function getDepartments()
    {
        // Retrieve all departments
        return Department::all();
    }

    public function getCourseSections()
    {
        // Get the student by UUID to find the program ID
        $student = $this->getStudentByUuid($this->uuid);
        $programId = $student->program_id;

        // Retrieve sections related to the student's program
        return CourseSection::whereHas('course.programCourses.program', function ($query) use ($programId) {
            $query->where('programs.program_id', $programId);
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
            'program_id',
            'phone_number',
            'profile_image',
            'email',
            'course_section_id'
        ]);
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Method to edit student data
    public function edit($id)
    {
        $this->resetErrorBag();

        try {
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
            $errors = $e->validator->errors()->all();
            $errorMessages = implode(' | ', $errors);

            return $this->logEditError('Invalid inputs: ' . $errorMessages, $student, 422);
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
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'success',
                'record_name' => $student->student_name,  // Log the student's last name for reference
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
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'error',
                'record_name' => $student->student_name,  // Log the student's last name for reference
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
   // Method for adding multiple course sections
    public function add()
    {
        $this->resetErrorBag(); // Reset any validation errors
        $this->resetInputFields(); // Reset all input fields to their initial state
        $this->showAddForm = true; // Show the add form modal for the user to enter data
    }

    // Function to store multiple course information
    public function store()
    {
        try {
            // Attempt to validate and create multiple courses
            $this->validateQueryStore();
        } catch (Exception $e) {
            // If an unexpected error occurs, log the system error
            $this->logSystemError('An error occurred while storing the courses.', $e);
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

    // Function to check if the form is populated
    public function isPopulated()
    {
        return !empty($this->course_section_id); // Assuming an array of course section IDs
    }

    // Function that is called if the user confirms to store the courses
    public function confirmStore() 
    {
        $this->store(); // Call the store method to save the new courses
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->showAddForm = false; // Close the add form modal
        $this->resetInputFields(); // Reset the input fields after storing the courses
    }

    // Function that is called if the user cancels the store action
    public function cancelStore() 
    {
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->showAddForm = true; // Show the add form modal again
        $this->resetErrorBag(); // Reset any validation errors
    }

    // Function to validate inputs and handle multiple course creation
    public function validateQueryStore() 
    {
        // Initialize an array to store all course objects for the response
        $courses = [];

        // Assuming input is an array of course data
        foreach ($this->course_section_id as $course_section_id) {
            // Initialize a new CourseSection for each course entry
            $course = new StudentCourse([
                'course_section_id' => $course_section_id,
            ]);

            try {
                // Attempt to create the course
                $createdCourse = $this->createCourse($course_section_id);

                // Log success and add to courses array
                $courses[] = $this->logAdd('Course successfully added!', $createdCourse, 201);

            } catch (ValidationException $e) {
                // Log validation error with the initialized $course
                $errors = $e->validator->errors()->all();
                $errorMessages = implode(' | ', $errors);

                $courses[] = $this->logAddError('Invalid inputs: ' . $errorMessages, $course, 422);

            } catch (QueryException $e) {
                // Handle duplicate entry error
                if ($e->errorInfo[1] == 1062) {
                    $courses[] = $this->logAddError('Course already assigned!', $course, 400);
                } else {
                    $courses[] = $this->logAddError('Database error: ' . $e->getMessage(), $course, 500);
                }
            }
        }

        // Return all courses' results (successes and errors)
        return $courses;
    }

    // Function to create the course entry in the database
    private function createCourse($course_section_id)
    {
        $student = $this->getStudentByUuid($this->uuid);

        // Check for a soft-deleted record with the same `course_section_id` and `student_id`
        $existingCourse = StudentCourse::withTrashed()->where([
            'course_section_id' => $course_section_id,
            'student_id' => $student->student_id,
        ])->first();

        if ($existingCourse) {
            if ($existingCourse->trashed()) {
                // Restore the soft-deleted record
                $existingCourse->restore();
                return $existingCourse;
            }
        }

        // If no matching record exists, create a new one
        return StudentCourse::create([
            'course_section_id' => $course_section_id,
            'student_id' => $student->student_id,
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
                'record_name' => $course->courseSection->section->section_code,  // Log the student's last name for reference
                'status_code' => $statusCode, // Log the HTTP status code (e.g., 201 for created)
            ])
            ->event('Courses Created') // Set the event name as "Courses Created"
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
                'record_name' => $course->courseSection->section->section_code,  // Log the student's last name for reference
                'status_code' => $statusCode, // Log the HTTP status code (e.g., 422 for validation errors)
            ])
            ->event('Failed to Add Courses') // Set the event name as "Failed to Add Courses"
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
            $course = StudentCourse::find($this->deleteId);

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
                'record_name' => $course->courseSection->section->section_code, // Log course name for reference\
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
                'student_course' => $course->courseSection->section->section_code, // Log course name for reference\
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
                $course = StudentCourse::withTrashed()->findOrFail($courseId);

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
                'record_name' => $course->courseSection->section->section_code,
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
                'record_name' => $course->courseSection->section->section_code,
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

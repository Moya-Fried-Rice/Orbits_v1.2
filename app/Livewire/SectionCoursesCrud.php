<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Livewire\Component;
use App\Models\Section;
use App\Models\CourseSection;
use App\Models\Program;

class SectionCoursesCrud extends Component
{
    public $uuid;
    public $course_id, $CourseSection, $program_id;
    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;
    public $deleteId;

    public function render()
    {
        // Retrieve the section data based on the provided UUID
        $section = $this->getSectionByUuid($this->uuid);

        // Render the view with the section data
        return view('livewire.section-courses-crud', compact('section'));
    }

    protected function getSectionByUuid($uuid)
    {
        // Return the Section record along with its associated course section
        return Section::with('courseSection')->where('uuid', $uuid)->first();
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
            'course_id'
        ]);
    }

    public function ordinal($number)
    {
        $suffixes = ['th', 'st', 'nd', 'rd'];
        $value = $number % 100;

        return $number . ($suffixes[($value - 20) % 10] ?? $suffixes[$value] ?? $suffixes[0]);
    }

    public function getPrograms()
    {
        $section = $this->getSectionByUuid($this->uuid);

        return Program::findOrFail($section->program_id);
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
        return !empty($this->course_id);
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
        // Initialize an array to store all course objects for the response
        $courses = [];

        // Assuming input is an array of course data
        foreach ($this->course_id as $course_id) {
            // Initialize a new CourseSection for each course entry
            $course = new CourseSection([
                'course_id' => $course_id,
            ]);

            try {
                // Attempt to create the course
                $createdCourse = $this->createCourse($course_id);

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
                // Handle other SQL errors
            }
        }

        // Return all courses' results (successes and errors)
        return $courses;
    }

    // Function to create the course entry in the database
    private function createCourse($course_id)
    {
        $section = $this->getSectionByUuid($this->uuid);

        // Check for a soft-deleted record with the same `course_id` and `section_id`
        $existingCourse = CourseSection::withTrashed()->where([
            'course_id' => $course_id,
            'section_id' => $section->section_id,
        ])->first();

        if ($existingCourse) {
            if ($existingCourse->trashed()) {
                // Restore the soft-deleted record
                $existingCourse->restore();
                return $existingCourse;
            }
        }

        // If no matching record exists, create a new one
        return CourseSection::create([
            'course_id' => $course_id,
            'section_id' => $section->section_id,
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
                'course_id' => $course->course_id,  // Log the course name for reference
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
            ->causedBy(Auth::user()) // Associate the logged action with the authenticated user
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
            $course = CourseSection::find($this->deleteId);

            if (!$course) {
                return $this->logRemoveError('Course not found!', $course, 404);
            }

            if ($course->studentCourse()->exists()) { 
                return $this->logRemoveError('Cannot delete the course as there are students currently enrolled.', $course, 400);
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
                'course_code' => $course->course->course_code, // Log course name for reference\
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
                'course_code' => $course->course->course_code, // Log course name for reference\
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
                $course = CourseSection::withTrashed()->findOrFail($courseId);

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
                'course_code' => $course->course->course_code,
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
                'course_code' => $course->course->course_code,
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

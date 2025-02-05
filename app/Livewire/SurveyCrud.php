<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Survey;
use App\Models\SurveyRole;
use App\Models\Role;

use Illuminate\Support\Facades\Auth;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SurveyCrud extends Component
{
    public $survey_name, $role_id;
    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;
    public $search = null, $deleteId, $selectedDepartment = null;

    public function render()
    {
        $surveys = Survey::all();
        
        return view('livewire.survey-crud', compact('surveys'));
    }

    protected $rules = [
        'survey_name' => 'required|string|max:255',
        'role_id' => 'required|exists:roles,role_id',
    ];

    public function getRoles()
    {
        return Role::where('role_name', '!=', 'admin')->get();
    }

    private function resetInputFields()
    {
        // Reset specific input fields to their initial state
        $this->reset(['survey_name', 'role_id']);
    }

    public function clearMessage()
    {
        session()->forget(['success', 'error', 'info', 'deleted']);
    }
















    // Function to show the add survey form
    public function add()
    {
        $this->resetErrorBag(); // Reset any validation errors
        $this->resetInputFields(); // Reset all input fields to their initial state
        $this->showAddForm = true; // Show the add form modal for the user to enter data
    }

    // Function to store the survey information
    public function store()
    {
        try {
            // Attempt to validate and create the survey
            $this->validateQueryStore();
        } catch (Exception $e) {
            // If an unexpected error occurs, log the system error
            $this->logSystemError('An error occurred while storing the survey.', $e);
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
        return !empty($this->survey_name) || !empty($this->role_id);
    }

    // Function that is called if the user confirms to store the survey
    public function confirmStore() 
    {
        $this->store(); // Call the store method to save the new survey
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->showAddForm = false; // Close the add form modal
        $this->resetInputFields(); // Reset the input fields after storing the survey
    }

    // Function that is called if the user cancels the store action
    public function cancelStore() 
    {
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->showAddForm = true; // Show the add form modal again
        $this->resetErrorBag(); // Reset any validation errors
    }

    // Function to validate inputs and handle survey creation
    public function validateQueryStore() 
    {
        // Initialize $survey with the intended input values
        $survey = new Survey([
            'survey_name' => $this->survey_name,
            'role_id' => $this->role_id
        ]);

        try {
            // Validate inputs using the $rules property
            $this->validate($this->rules);

            // Attempt to create the survey
            $survey = $this->createSurvey();

            // Log success and return a success response
            return $this->logAdd('Survey successfully added!', $survey, 201);

        } catch (ValidationException $e) {
            // Log validation error with the initialized $survey
            $errors = $e->validator->errors()->all();
            $errorMessages = implode(' | ', $errors);

            return $this->logAddError('Invalid inputs: ' . $errorMessages, $survey, 422);
        } catch (QueryException $e) {
            // Handle database errors
            return $this->logAddError('Database error: ' . $e->getMessage(), $survey, 500);
        }
    }

    // Function to create the survey entry in the database
    private function createSurvey()
    {
        $survey = Survey::create([
            'survey_name' => $this->survey_name,
        ]);

        if (!empty($this->role_id)) {
            foreach ($this->role_id as $role) {
                SurveyRole::create([
                    'survey_id' => $survey->survey_id,
                    'role_id' => $role, // Assuming the roles are stored as 'role_name'
                ]);
            }
        }

        return $survey;
    }

    // Function to log a successful survey creation
    private function logAdd($message, $survey, $statusCode)
    {
        // Flash success message to the session for user feedback
        session()->flash('success', $message);

        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($survey) // Attach the log to the survey object
            ->causedBy(Auth::user()) // Associate the logged action with the authenticated user
            ->withProperties([ // Add any additional properties to log
                'status' => 'success', // Mark the status as success
                'record_name' => $survey->survey_name,  // Log the survey name for reference
                'status_code' => $statusCode, // Log the HTTP status code (e.g., 201 for created)
            ])
            ->event('Survey Created') // Set the event name as "Survey Created"
            ->log($message); // Log the custom success message
    }

    // Function to log an error when survey creation fails
    private function logAddError($message, $survey, $statusCode)
    {
        // Flash error message to the session for user feedback
        session()->flash('error', $message);

        // Log the activity using Spatie Activitylog
        activity()
            ->causedBy(Auth::user()) // Associate the logged action with the authenticated user
            ->withProperties([ // Add any additional properties to log
                'status' => 'error', // Mark the status as error
                'record_name' => $survey, // Mark the status as error
                'status_code' => $statusCode, // Log the HTTP status code (e.g., 422 for validation errors)
            ])
            ->event('Failed to Add Survey') // Set the event name as "Failed to Add Survey"
            ->log($message); // Log the custom error message
    }

    // Function to close the add survey form and reset everything
    public function closeAdd() 
    {
        $this->showAddForm = false; // Close the add form modal
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->resetInputFields(); // Reset input fields
        $this->resetErrorBag(); // Reset any validation errors
    }


















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
        $this->remove(); // Proceed to delete survey from the database
        $this->resetDeleteState(); // Close confirmation modal and reset state
    }

    // If canceled
    public function cancelDelete()
    {
        $this->resetDeleteState(); // Close confirmation modal and reset state
    }

    // Reset delete state to prepare for the next action
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
            $this->logSystemError('An error occurred while deleting the survey.', $e);
        } finally {
            session()->forget('deleteId');
        }
    }

    // Validate and process deletion
    public function validateQueryRemove()
    {
        try {
            // Retrieve survey by ID
            $survey = Survey::find($this->deleteId);

            if (!$survey) {
                return $this->logRemoveError('Survey not found!', null, 404);
            }

            // Check for related records (dependencies) that prevent deletion
            if ($survey->questionCriterias()->exists()) {
                return $this->logRemoveError('Cannot delete the survey as it has assigned criterias.', $survey, 400);
            }

            // Soft delete the survey
            $this->deleteSurvey($survey);

        } catch (QueryException $e) {
            // Handle database query exceptions
            return $this->logRemoveError('Database error: ' . $e->getMessage(), $survey, 500);
        }
    }

    // Soft delete the survey and log success
    private function deleteSurvey($survey)
    {
        $survey->delete();  // Perform soft delete

        // Log the successful deletion
        return $this->logRemove('Survey successfully deleted!', $survey, 200);
    }

    // Log successful survey removal
    private function logRemove($message, $survey, $statusCode)
    {
        // Flash deleted ID for restoration to the session
        session()->put('deleted_record_id', $this->deleteId);

        // Flash success message to the session
        session()->flash('deleted', $message);

        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($survey)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'success',  // Status: success
                'record_name' => $survey->survey_name, // Log survey name for reference
                'status_code' => $statusCode, // HTTP status code (e.g., 200 for successful removal)
            ])
            ->event('Survey Removed') // Event: Survey Removed
            ->log($message); // Log the custom success message
    }

    // Log an error when survey removal fails
    private function logRemoveError($message, $survey, $statusCode)
    {
        // Flash error message to the session
        session()->flash('error', $message);

        // Log the activity using Spatie Activitylog
        activity()
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'error',  // Status: error
                'record_name' => $survey ? $survey->survey_name : 'Unknown', // Ensure no null errors
                'status_code' => $statusCode, // HTTP status code (e.g., 400, 422 for failure cases)
            ])
            ->event('Failed to Remove Survey') // Event: Failed to Remove Survey
            ->log($message); // Log the custom error message
    }







    // Method for restoring deleted survey
    public function undoDelete()
    {
        // Get the deleted survey ID from the session
        $surveyId = session()->get('deleted_record_id');

        if ($surveyId) {
            try {
                // Retrieve the survey including trashed ones
                $survey = Survey::withTrashed()->findOrFail($surveyId);

                // Check if the survey is already active or needs restoration
                $this->checkIfRestored($survey);
            } catch (ModelNotFoundException $e) {
                // Log error if survey is not found
                $this->logSystemError('Survey not found for restoration!', $e);
            } catch (Exception $e) {
                // Log any other exceptions
                $this->logSystemError('Failed to restore survey', $e);
            }
        } else {
            // Handle case where no deleted survey is found in session
            session()->flash('error', 'No survey available to restore!');
        }
    }

    // Check if the survey is already restored
    private function checkIfRestored($survey)
    {
        if (!$survey->trashed()) {
            // Log if the survey is already active
            $this->logRestorationError('Survey is already active', $survey, 400);
            return;
        } else {
            // Restore the survey if it’s trashed
            $this->restoreSurvey($survey);
        }
    }

    // Restore the survey
    private function restoreSurvey($survey)
    {
        try {
            // Attempt to restore the survey
            $survey->restore();
            
            // Clear the session for deleted survey ID
            session()->forget('deleted_record_id');

            // Log the restoration success
            $this->logRestoration('Survey successfully restored!', $survey, 200);
        } catch (Exception $e) {
            // Log any errors during the restoration process
            $this->logRestorationError('Failed to restore survey', $survey, 500);
        }
    }

    // Log the survey restoration
    private function logRestoration($message, $survey, $statusCode)
    {
        session()->flash('success', $message);

        // Log activity using Spatie Activitylog
        activity()
            ->performedOn($survey)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'success',
                'record_name' => $survey->survey_name,
                'status_code' => $statusCode,
            ])
            ->event('Survey Restored')
            ->log('Survey restored');
    }

    // Log restoration error
    private function logRestorationError($message, $survey, $statusCode)
    {
        session()->flash('error', $message);

        // Log activity using Spatie Activitylog
        activity()
            ->performedOn($survey)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'error',
                'record_name' => $survey->survey_name,
                'status_code' => $statusCode,
            ])
            ->event('Survey Restore Failed')
            ->log('Failed to restore survey');
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
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Survey;
use App\Models\QuestionCriteria;
use App\Models\Question;
use App\Models\Role;

use Illuminate\Support\Facades\Auth;

use InvalidArgumentException;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SurveyQuestionsCrud extends Component
{
    

    public $uuid;
    public $selectedCriteria;

    public $name;
    public $survey_name;
    public $description;
    public $question_text;
    public $survey_id;
    public $question_id;
    public $criteria_id;
    public $role_id;

    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;

    public $oldValues;
    
    public function render()
    {
        $survey = $this->getSurveyByUuid($this->uuid); // Fetch survey

        if (!$survey) {
            session()->flash('error', 'Survey not found!');
        }

        // Set default selected criteria if it's not already set
        if (!$this->selectedCriteria && $survey->surveyCriteria->isNotEmpty()) {
            $this->selectedCriteria = $survey->surveyCriteria->first()->criteria_id;
        }

        return view('livewire.survey-questions-crud', compact('survey'));
    }

    public function getRoles()
    {
        return Role::where('role_name', '!=', 'admin')->get();
    }
    

    public function selectCriteria($id)
    {
        $this->selectedCriteria = $id; // Update the state
    }

    protected function getSurveyByUuid($uuid)
    {
        $survey = Survey::where('uuid', $uuid)
            ->with('surveyCriteria.questionCriteria.questions') // Eager load all related data
            ->first();
    
        return $survey;
    }

    // Validation rules
    protected $rules = [
        'survey_name' => 'required|string|max:255',
        'description' => 'required|string|max:500',
        'question_text' => 'required|string|max:500',
        'role_id' => 'required|exists:roles,role_id',
        
    ];

    public function clearMessage()
    {
        session()->forget(['success', 'error', 'info', 'deleted']);
    }

    private function resetInputFields()
    {
        // Reset specific properties that should be reset, excluding `$uuid`
        $this->reset(['name', 'survey_name', 'description', 'question_text', 'survey_id', 'question_id', 'criteria_id']);
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Method to edit course data
    public function edit($id, $name)
    {
        $this->name = $name;

        $this->resetErrorBag(); // Reset any previous errors
    
        try {

            if ($name == 'survey') {
                $this->populateSurvey($id);
            } elseif ($name == 'criteria') {
                $this->populateCriteria($id);
            }  elseif ($name == 'question') {
                $this->populateQuestion($id);
            }   

            $this->showEditForm = true;
        } catch (ModelNotFoundException $e) {
            // Log error if course is not found
            $this->logSystemError( ucfirst($name) . ' not found', $e);
        } catch (Exception $e) {
            // Log general errors
            $this->logSystemError('Failed to load' . ucfirst($name), $e);
        }
    }

    public function populateSurvey($id) 
    {
        $survey = Survey::findOrFail($id);
    
        // Populate input fields with course data
        $this->survey_id = $survey->survey_id;
        $this->survey_name = $survey->survey_name;
        $this->role_id = $survey->surveyRole->pluck('role_id')->toArray();
    }

    public function populateCriteria($id) 
    {
        $criteria = QuestionCriteria::findOrFail($id);
    
        // Populate input fields with course data
        $this->criteria_id = $criteria->criteria_id;
        $this->description = $criteria->description;
    }

    public function populateQuestion($id) 
    {
        $question = Question::findOrFail($id);
    
        // Populate input fields with course data
        $this->question_id = $question->question_id;
        $this->question_text = $question->question_text;
    }


    // Step 2: Show update confirmation
    public function updateConfirmation()
    {
    
        // Check if any changes were made
        if (!$this->isUpdated($this->name)) {
            // If no changes, show a message and return
            session()->flash('info', 'No changes were made to the ' . $this->name . '.');
            $this->showEditForm = false;
            $this->showEditConfirmation = false;
            return;
        }
    
        // Close the edit form and show confirmation if there are changes
        $this->showEditForm = false;
        $this->showEditConfirmation = true;
    }

    private function isUpdated($name)
    {
        switch ($name) {
            case 'survey':
                $survey = Survey::find($this->survey_id);
                $surveyRoles = $survey->surveyRole->pluck('role_id')->toArray();
                $roleIds = array_map('intval', $this->role_id);
                sort($surveyRoles);
                sort($roleIds);

                return $survey && (
                    $survey->survey_name !== $this->survey_name || 
                    $surveyRoles !== $roleIds
                );

            case 'criteria':
                $criteria = QuestionCriteria::find($this->criteria_id);
                return $criteria && (
                    $criteria->description !== $this->description
                );

            case 'question':
                $question = Question::find($this->question_id);
                return $question && (
                    $question->question_text !== $this->question_text
                );

            default:
                return false;
        }
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

    public function update()
    {
        try {
            // Only proceed with the update if changes were made
            if (!$this->isUpdated($this->name)) {
                session()->flash('info', 'No changes were made to the ' . ucfirst($this->name) . '.');
                return;
            }
    
            // Validate and update based on the entity type
            $this->validateQueryEdit();
    
            // Proceed with the update logic (You can add your update code here, if applicable)
            // Example:
            // $this->saveEntity();
    
        } catch (Exception $e) {
            // Handle any exceptions during the update process
            $this->logSystemError('An error occurred while updating the ' . $this->name . '.', $e);
        } finally {
            // Reset input fields after the operation
            $this->resetInputFields();
        }
    }
    

    public function validateQueryEdit()
    {
        // Attempt to edit the appropriate entity based on $this->name (survey, criteria, or question)
        $entity = $this->editEntity($this->name);
    
        try {
            // Validate inputs using defined rules
                 
            if ($this->name == 'survey') {
                $this->validate([
                    'survey_name' => $this->rules['survey_name'],
                    'role_id' => $this->rules['role_id']
                ]); 
            }
    
            if ($this->name == 'criteria') {
                $this->validate([
                    'description' => $this->rules['description'],
                ]); 
            }
    
            if ($this->name == 'question') {
                $this->validate([
                    'question_text' => $this->rules['question_text'],
                ]); 
            }

            // Save the changes to the database
            $entity->save();

            // Log the successful update along with changes and return a success response
            return $this->logEdit(ucfirst($this->name) . ' successfully updated!', $entity, 200);
        } catch (ValidationException $e) {
            // Handle validation errors (e.g., invalid inputs)
            $errors = $e->validator->errors()->all();
            $errorMessages = implode(' | ', $errors);
    
            return $this->logEditError('Invalid inputs: ' . $errorMessages, $entity, 422);
        } catch (QueryException $e) {
            // Handle database-related errors
            if ($e->errorInfo[1] == 1062) {
                // Specific error for duplicate entries (e.g., name or code)
                return $this->logEditError(ucfirst($this->name) . ' already exists!', $entity, 400);
            }
    
            // General database error
            return $this->logEditError('Database error: ' . $e->getMessage(), $entity, 500);
        }
    }
    
    // Function to retrieve and update the appropriate entity in the database (survey, criteria, or question)
    private function editEntity($name)
    {
        switch ($name) {
            case 'survey':
                $survey = Survey::find($this->survey_id);
                if (!$survey) {
                    throw new ModelNotFoundException('Survey not found!');
                }
    
                // Store old values to log changes
                $this->oldValues = array_merge($survey->getOriginal(), ['role_id' => $survey->surveyRole->pluck('role_id')->toArray()]);
    
                // Update roles (SurveyRole table)
                // 1. Remove any existing roles that are no longer selected
                $survey->surveyRole()->whereNotIn('role_id', $this->role_id)->delete();
    
                // 2. Add any new roles that were selected but are not in the SurveyRole table
                foreach ($this->role_id as $roleId) {
                    if (!$survey->surveyRole->contains('role_id', $roleId)) {
                        $survey->surveyRole()->create([
                            'role_id' => $roleId
                        ]);
                    }
                }
    
                return $survey;
    
            case 'criteria':
                $criteria = QuestionCriteria::find($this->criteria_id);
                if (!$criteria) {
                    throw new ModelNotFoundException('Criteria not found!');
                }
    
                // Store old values to log changes
                $this->oldValues = $criteria->getOriginal();
    
                // Update criteria properties
                $criteria->description = $this->description;
                return $criteria;
    
            case 'question':
                $question = Question::find($this->question_id);
                if (!$question) {
                    throw new ModelNotFoundException('Question not found!');
                }
    
                // Store old values to log changes
                $this->oldValues = $question->getOriginal();
    
                // Update question properties
                $question->question_text = $this->question_text;
                return $question;
    
            default:
                throw new InvalidArgumentException('Invalid entity type: ' . $name);
        }
    }

    // Log edit for any entity (survey, criteria, question)
    private function logEdit($message, $entity, $statusCode)
    {
        // Flash success message to the session
        session()->flash('success', $message);

        // Compare old and new values to log changes
        $changes = $this->compareChanges(
            array_merge($this->oldValues, ['role_id' => $this->oldValues['role_id'] ?? []]),
            array_merge($entity->getAttributes(), ['role_id' => $this->role_id])
        );

        // Log the activity
        activity()
            ->performedOn($entity)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'success',
                'record_name' => $entity->survey_name ?? $entity->question_text ?? $entity->description, // Adjust based on entity
                'status_code' => $statusCode,
                'changes' => $changes, // Include changes in the log
            ])
            ->event('Edit')
            ->log($message); // Log the success message
    }

    // Compare the old and new values to find changes for any entity
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

    // Log edit error for any entity (survey, criteria, question)
    private function logEditError($message, $entity, $statusCode)
    {
        session()->flash('error', $message); // Flash error message

        activity()
            ->performedOn($entity)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'error',
                'record_name' => $entity->name ?? $entity->question_text ?? $entity->description, // Adjust based on entity
                'status_code' => $statusCode,
            ])
            ->event('Failed Edit')
            ->log($message); // Log activity
    }

    public function closeEdit()
    {
        $this->showEditForm = false;
        $this->showEditConfirmation = false;
        $this->resetErrorBag(); // Reset error bag
    }
    































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

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

    public $survey_name;
    public $description;
    public $question_text;
    public $survey_id;
    public $question_id;
    public $criteria_id;
    public $role_id;
    public $deleteId;
    public $deleteType;
    public $editType;
    public $addType;

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
        if (!$this->selectedCriteria && $survey->questionCriteria->isNotEmpty()) {
            $this->selectedCriteria = $survey->questionCriteria->first()->criteria_id;
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
            ->with('questionCriteria.questions') // Eager load all related data
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
        $this->reset(['deleteType', 'editType', 'survey_name', 'description', 'question_text', 'survey_id', 'question_id', 'criteria_id']);
    }



    public function updateOrderCriteria($list) 
    {
        foreach($list as $item) {
            QuestionCriteria::find($item['value'])->update(['position' => $item['order']]);
        }
    }

    public function updateOrderQuestion($list) 
    {
        foreach($list as $item) {
            Question::find($item['value'])->update(['position' => $item['order']]);
        }
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Method to edit course data
    public function edit($id, $type)
    {
        $this->editType = $type;

        $this->resetErrorBag(); // Reset any previous errors
    
        try {

            if ($type == 'survey') {
                $this->populateSurvey($id);
            } elseif ($type == 'criteria') {
                $this->populateCriteria($id);
            }  elseif ($type == 'question') {
                $this->populateQuestion($id);
            }   

            $this->showEditForm = true;
        } catch (ModelNotFoundException $e) {
            // Log error if course is not found
            $this->logSystemError( ucfirst($type) . ' not found', $e);
        } catch (Exception $e) {
            // Log general errors
            $this->logSystemError('Failed to load' . ucfirst($type), $e);
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
        if (!$this->isUpdated($this->editType)) {
            // If no changes, show a message and return
            session()->flash('info', 'No changes were made to the ' . $this->editType . '.');
            $this->showEditForm = false;
            $this->showEditConfirmation = false;
            return;
        }
    
        // Close the edit form and show confirmation if there are changes
        $this->showEditForm = false;
        $this->showEditConfirmation = true;
    }

    private function isUpdated($type)
    {
        switch ($type) {
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
            if (!$this->isUpdated($this->editType)) {
                session()->flash('info', 'No changes were made to the ' . ucfirst($this->editType) . '.');
                return;
            }
    
            // Validate and update based on the entity type
            $this->validateQueryEdit();
    
            // Proceed with the update logic (You can add your update code here, if applicable)
            // Example:
            // $this->saveEntity();
    
        } catch (Exception $e) {
            // Handle any exceptions during the update process
            $this->logSystemError('An error occurred while updating the ' . $this->editType . '.', $e);
        } finally {
            // Reset input fields after the operation
            $this->resetInputFields();
        }
    }
    

    public function validateQueryEdit()
    {
        // Attempt to edit the appropriate entity based on $this->editType (survey, criteria, or question)
        $entity = $this->editEntity($this->editType);
    
        try {
            // Validate inputs using defined rules
                 
            if ($this->editType == 'survey') {
                $this->validate([
                    'survey_name' => $this->rules['survey_name'],
                    'role_id' => $this->rules['role_id']
                ]); 
            }
    
            if ($this->editType == 'criteria') {
                $this->validate([
                    'description' => $this->rules['description'],
                ]); 
            }
    
            if ($this->editType == 'question') {
                $this->validate([
                    'question_text' => $this->rules['question_text'],
                ]); 
            }

            // Save the changes to the database
            $entity->save();

            // Log the successful update along with changes and return a success response
            return $this->logEdit(ucfirst($this->editType) . ' successfully updated!', $entity, 200);
        } catch (ValidationException $e) {
            // Handle validation errors (e.g., invalid inputs)
            $errors = $e->validator->errors()->all();
            $errorMessages = implode(' | ', $errors);
    
            return $this->logEditError('Invalid inputs: ' . $errorMessages, $entity, 422);
        } catch (QueryException $e) {
            // Handle database-related errors
            if ($e->errorInfo[1] == 1062) {
                // Specific error for duplicate entries (e.g., name or code)
                return $this->logEditError(ucfirst($this->editType) . ' already exists!', $entity, 400);
            }
    
            // General database error
            return $this->logEditError('Database error: ' . $e->getMessage(), $entity, 500);
        }
    }
    
    // Function to retrieve and update the appropriate entity in the database (survey, criteria, or question)
    private function editEntity($type)
    {
        switch ($type) {
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
    
                $survey->survey_name = $this->survey_name;
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
                throw new InvalidArgumentException('Invalid entity type: ' . $type);
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
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Method for deleting data
    public function delete($id, $type)
    {
        $this->deleteId = $id;
        $this->deleteType = $type;
        $this->showDeleteConfirmation = true;
    }
    
    public function confirmDelete()
    {
        $this->remove();
        $this->resetDeleteState();
    }
    
    public function cancelDelete()
    {
        $this->resetDeleteState();
    }
    
    private function resetDeleteState()
    {
        $this->showDeleteConfirmation = false;
        $this->deleteId = null;
        $this->deleteType = null;
    }
    
    public function remove()
    {
        try {
            $this->validateQueryRemove();
        } catch (Exception $e) {
            $this->logSystemError('An error occurred while deleting the ' . ucfirst($this->deleteType) . '.', $e);
        }
    }
    
    public function validateQueryRemove()
    {
        try {
            switch ($this->deleteType) {
                case 'question':
                    $entity = Question::find($this->deleteId);
                    if (!$entity) {
                        return $this->logRemoveError('Question not found!', null, 404);
                    }
                    break;
                
                case 'criteria':
                    $entity = QuestionCriteria::find($this->deleteId);
                    if (!$entity) {
                        return $this->logRemoveError('Criteria not found!', null, 404);
                    }
                    // Prevent deleting if criteria has associated questions
                    if ($entity->questions()->exists()) {
                        return $this->logRemoveError('Cannot delete criteria as it has associated questions.', $entity, 400);
                    }
                    break;
                
                default:
                    throw new InvalidArgumentException('Invalid delete type.');
            }
    
            $this->deleteEntity($entity);
        } catch (QueryException $e) {
            return $this->logRemoveError('Database error: ' . $e->getMessage(), $entity ?? null, 500);
        }
    }
    
    private function deleteEntity($entity)
    {
        $entity->delete();
        return $this->logRemove(ucfirst($this->deleteType) . ' successfully deleted!', $entity, 200);
    }
    
    private function logRemove($message, $entity, $statusCode)
    {
        session()->put('deleted_record_id', $this->deleteId);
        session()->put('deleted_record_type', $this->deleteType);

        session()->flash('deleted', $message);
        activity()
            ->performedOn($entity)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'success',
                'record_name' => $entity->question_text ?? $entity->description,
                'status_code' => $statusCode,
            ])
            ->event(ucfirst($this->deleteType) . ' Removed')
            ->log($message);
    }
    
    private function logRemoveError($message, $entity, $statusCode)
    {
        session()->flash('error', $message);
        activity()
            ->performedOn($entity)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'error',
                'record_name' => $entity->question_text ?? $entity->description ?? 'Unknown',
                'status_code' => $statusCode,
            ])
            ->event('Failed to Remove ' . ucfirst($this->deleteType))
            ->log($message);
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Method to add question or criteria
    public function add($type)
    {
        $this->addType = $type;
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
        if ($this->addType == 'question') {
            return !empty($this->question_text);
        } elseif ($this->addType == 'criteria') {
            return !empty($this->description);
        }
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
    
    public function validateQueryStore() 
    {
        // Initialize $course with the intended input values
        if ($this->addType == 'question') {
            $entity = new Question([
                'question_text' => $this->question_text,
            ]);
        }

        if ($this->addType == 'criteria') {
            $entity = new QuestionCriteria([
                'description' => $this->description,
                'survey_id' => $this->survey_id,
            ]);
        }

        try {
            
            if ($this->addType == 'question') {
                $this->validate([
                    'question_text' => $this->rules['question_text'],
                ]); 

                $entity = $this->createQuestion();
            }
            
            if ($this->addType == 'criteria') {
                $this->validate([
                    'description' => $this->rules['description'],
                ]); 

                $entity = $this->createCriteria();
            }

            // Log success and return a success response
            return $this->logAdd('Question successfully added!', $entity, 201);

        } catch (ValidationException $e) {
            // Log validation error with the initialized $question
            $errors = $e->validator->errors()->all();
            $errorMessages = implode(' | ', $errors);

            return $this->logAddError('Invalid inputs: ' . $errorMessages, $entity, 422);
        } catch (QueryException $e) {
            // Handle duplicate entry error
            if ($e->errorInfo[1] == 1062) {
                return $this->logAddError('Question already exists!', $entity, 400);
            }

            // Handle other SQL errors
            return $this->logAddError('Database error: ' . $e->getMessage(), $entity, 500);
        }
    }

    // Function to create the course entry in the database
    private function createQuestion()
    {
        return Question::create([
            'question_code' => 'asd',
            'question_text' => $this->question_text,
            'criteria_id' => $this->selectedCriteria
        ]);
    }

    private function createCriteria()
    {
        $survey = $this->getSurveyByUuid($this->uuid);

        return QuestionCriteria::create([
            'description' => $this->description,
            'survey_id' => $survey->survey_id
        ]);
    }

    private function logAdd($message, $question, $statusCode)
    {
        // Flash success message to the session for user feedback
        session()->flash('success', $message);
        
        // Log the activity using Spatie Activitylog
        activity()
            ->performedOn($question) // Attach the log to the question object
            ->causedBy(Auth::user()) // Associate the logged action with the authenticated user
            ->withProperties([ // Add any additional properties to log
                'status' => 'success', // Mark the status as success
                'record_name' => $question->question_text,  // Log the question name for reference
                'status_code' => $statusCode, // Log the HTTP status code (e.g., 201 for created)
            ])
            ->event('Question Created') // Set the event name as "question Created"
            ->log($message); // Log the custom success message
    }

    private function logAddError($message, $question, $statusCode)
    {
        // Flash error message to the session for user feedback
        session()->flash('error', $message);
        
        // Log the activity using Spatie Activitylog
        activity()
            ->causedBy(Auth::user()) // Associate the logged action with the authenticated user
            ->withProperties([ // Add any additional properties to log
                'status' => 'error', // Mark the status as error
                'record_name' => $question, // Mark the status as error
                'status_code' => $statusCode, // Log the HTTP status code (e.g., 422 for validation errors)
            ])
            ->event('Failed to Add Question') // Set the event name as "Failed to Add Course"
            ->log($message); // Log the custom error message
    }
    
    public function closeAdd() 
    {
        $this->showAddForm = false; // Close the add form modal
        $this->showAddConfirmation = false; // Close the confirmation modal
        $this->resetInputFields(); // Reset input fields
        $this->resetErrorBag(); // Reset any validation errors
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Method for restoring deleted question or criteria
    public function undoDelete()
    {
        // Get the deleted record ID and type from the session
        $deletedId = session()->get('deleted_record_id');
        $deletedType = session()->get('deleted_record_type');

        if ($deletedId && $deletedType) {
            try {
                // Retrieve the appropriate model based on the type
                $entity = $this->getTrashedEntity($deletedId, $deletedType);

                // Check if already restored or proceed with restoration
                $this->checkIfRestored($entity, $deletedType);
            } catch (ModelNotFoundException $e) {
                $this->logSystemError(ucfirst($deletedType) . ' not found for restoration!', $e);
            } catch (Exception $e) {
                $this->logSystemError('Failed to restore ' . ucfirst($deletedType), $e);
            }
        } else {
            session()->flash('error', 'No record available to restore!');
        }
    }

    // Retrieve the trashed entity
    private function getTrashedEntity($id, $type)
    {
        switch ($type) {
            case 'question':
                return Question::withTrashed()->findOrFail($id);
            case 'criteria':
                return QuestionCriteria::withTrashed()->findOrFail($id);
            default:
                throw new InvalidArgumentException('Invalid entity type: ' . $type);
        }
    }

    // Check if already restored
    private function checkIfRestored($entity, $type)
    {
        if (!$entity->trashed()) {
            $this->logRestorationError(ucfirst($type) . ' is already active', $entity, 400);
        } else {
            $this->restoreEntity($entity, $type);
        }
    }

    // Restore the entity
    private function restoreEntity($entity, $type)
    {
        try {
            $entity->restore();
            session()->forget(['deleted_record_id', 'deleted_record_type']);
            $this->logRestoration(ucfirst($type) . ' successfully restored!', $entity, 200);
        } catch (Exception $e) {
            $this->logRestorationError('Failed to restore ' . ucfirst($type), $entity, 500);
        }
    }

    // Log successful restoration
    private function logRestoration($message, $entity, $statusCode)
    {
        session()->flash('success', $message);
        activity()
            ->performedOn($entity)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'success',
                'record_name' => $entity->question_text ?? $entity->description,
                'status_code' => $statusCode,
            ])
            ->event('Restore')
            ->log($message);
    }

    // Log restoration error
    private function logRestorationError($message, $entity, $statusCode)
    {
        session()->flash('error', $message);
        activity()
            ->performedOn($entity)
            ->causedBy(Auth::user())
            ->withProperties([
                'status' => 'error',
                'record_name' => $entity->question_text ?? $entity->description,
                'status_code' => $statusCode,
            ])
            ->event('Restore')
            ->log($message);
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑










    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
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

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Survey;

class SurveyQuestionsCrud extends Component
{
    public $uuid;
    public $selectedCriteria;
    
    public function render()
    {
        $survey = $this->getSurveyByUuid($this->uuid); // Fetch survey

        // Set default selected criteria if it's not already set
        if (!$this->selectedCriteria && $survey->surveyCriteria->isNotEmpty()) {
            $this->selectedCriteria = $survey->surveyCriteria->first()->criteria_id;
        }

        return view('livewire.survey-questions-crud', compact('survey'));
    }

    public function selectCriteria($id)
    {
        $this->selectedCriteria = $id; // Update the state
    }

    protected function getSurveyByUuid($uuid)
    {
        return Survey::where('uuid', $uuid)
            ->with('surveyCriteria.questionCriteria.questions') // Eager load all related data
            ->first();
    }
    
}

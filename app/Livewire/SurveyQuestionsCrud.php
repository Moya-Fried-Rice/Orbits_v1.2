<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Survey;

class SurveyQuestionsCrud extends Component
{
    public $uuid;

    public function render()
    {
        $survey = $this->getSurveyByUuid($this->uuid);
        
        return view('livewire.survey-questions-crud', compact('survey'));
    }

    protected function getSurveyByUuid($uuid)
    {
        return Survey::where('uuid', $uuid)
            ->with('surveyCriteria.questionCriteria.questions') // Eager load all related data
            ->first();
    }
    
}

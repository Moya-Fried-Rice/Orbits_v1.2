<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Survey;

class SurveyQuestionsCrud extends Component
{
    public $uuid;

    public function render()
    {
        $surveys = $this->getSurveyByUuid($this->uuid);
        
        return view('livewire.survey-questions-crud', compact('surveys'));
    }

    protected function getSurveyByUuid($uuid)
    {
        // Return the faculty record along with its associated department
        return Survey::where('uuid', $uuid)->first();
    }
}

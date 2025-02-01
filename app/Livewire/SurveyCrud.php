<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Survey;

class SurveyCrud extends Component
{
    public function render()
    {
        $surveys = Survey::all();
        
        return view('livewire.survey-crud', compact('surveys'));
    }

    public function getSurvey() {
        return Survey::all();
    }
}

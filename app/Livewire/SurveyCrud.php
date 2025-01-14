<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EvaluationPeriod;

class SurveyCrud extends Component
{
    public $periodId = 1; // To capture the selected period ID
    public $surveys = []; // To store the surveys for the selected period

    // Method to show surveys for a specific evaluation period
    public function showSurveysForPeriod()
    {
        // Ensure periodId is set and valid
        if ($this->periodId) {
            $evaluationPeriod = EvaluationPeriod::findOrFail($this->periodId);
            // Retrieve surveys associated with this evaluation period as a collection
            $this->surveys = $evaluationPeriod->surveys()->get(); // Use `get()` to get an Eloquent collection
        }
    }

    public function render()
    {
        // Retrieve all evaluation periods for the dropdown
        $evaluationPeriods = EvaluationPeriod::all();

        return view('livewire.survey-crud', compact('evaluationPeriods'));
    }
}

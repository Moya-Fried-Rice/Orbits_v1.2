<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\UserEvaluation;

class Evaluation extends Component
{
    public $studentId;

    public function render()
    {   
        $user = Auth::user()->user_id;

        $evaluations = UserEvaluation::where('user_id', $user)
        ->where('is_completed', false)
        ->with('evaluation.courseSection.course', 'evaluation.survey.questionCriterias.questions') // Eager load relationships
        ->get();    

        return view('livewire.evaluation', compact('evaluations'));

    }
}

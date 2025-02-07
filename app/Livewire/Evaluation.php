<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentEvaluation;
use App\Models\ResponseStudent;

class Evaluation extends Component
{
    public $studentId;

    public function render()
    {   
        $studentId = Auth::user()->student->student_id;

        $evaluations = StudentEvaluation::where('student_id', $studentId)
        ->where('is_completed', false)
        ->with('courseSection.course', 'survey.questionCriterias.questions') // Eager load relationships
        ->get();    

        return view('livewire.evaluation', compact('evaluations'));

    }
}

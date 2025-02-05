<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentEvaluation;
use App\Models\ResponseStudent;

class Evaluation extends Component
{
    public $studentId;
    public $responses = [];
    public $comments = [];

    public function render()
    {   
        $studentId = Auth::user()->student->student_id;

        $evaluations = StudentEvaluation::where('student_id', $studentId)
        ->where('is_completed', false)
        ->with('courseSection.course', 'survey.questionCriteria.questions') // Eager load relationships
        ->get();    

        return view('livewire.evaluation', compact('evaluations'));

    }


    public function submitEvaluation($studentEvaluationId)
    {
        // Ensure we only process evaluations that are valid and not yet completed
        $studentEvaluation = StudentEvaluation::find($studentEvaluationId);
        $responses = $this->responses[$studentEvaluationId] ?? [];

        if (!$studentEvaluation) {
            // Handle case where evaluation is not found
            session()->flash('error', 'Evaluation not found.');
            return;
        }

        // Loop through the responses and save them in the response_students table
        foreach ($responses as $questionId => $rating) {
            // Validate that a rating was provided
            if ($rating) {
                // Store the response in the response_students table
                ResponseStudent::create([
                    'student_evaluation_id' => $studentEvaluationId,
                    'question_id' => $questionId,
                    'rating' => $rating,
                ]);
            }
        }

        // Store comments if provided
        if (isset($this->comments[$studentEvaluationId]) && $this->comments[$studentEvaluationId]) {
            // Assuming you have a field for storing comments, if necessary
            $studentEvaluation->update([
                'comment' => $this->comments[$studentEvaluationId], // Assuming there's a comments column
            ]);
        }

        // Optionally mark the evaluation as completed
        $studentEvaluation->update(['is_completed' => true]);

        // Provide a success message
        session()->flash('success', 'Evaluation submitted successfully!');
    }
}

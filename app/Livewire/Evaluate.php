<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\StudentEvaluation;
use App\Models\ResponseStudent;

class Evaluate extends Component
{
    public $uuid;
    public $responses = [];
    public $comments = [];
    
    public function render()
    {
        // Retrieve the section data based on the provided UUID
        $evaluation = $this->getEvaluationByUuid($this->uuid);

        // Render the view with the section data
        return view('livewire.evaluate', compact('evaluation'));
    }

    protected function getEvaluationByUuid($uuid)
    {
        // Return the Section record along with its associated course section
        return StudentEvaluation::with('responseStudents')->where('uuid', $uuid)->first();
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
        $studentEvaluation->update([
            'is_completed' => true,
            'evaluated_at' => now(), // Sets the current timestamp
        ]);        

        // Provide a success message
        session()->flash('success', 'Evaluation submitted successfully!');

        return redirect('/evaluation');
    }
}

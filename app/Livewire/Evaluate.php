<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UserEvaluation;
use App\Models\Response;

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
        return UserEvaluation::with('responses')->where('uuid', $uuid)->first();
    }

    public function submitEvaluation($userEvaluationId)
    {
        // Ensure we only process evaluations that are valid and not yet completed
        $userEvaluation = UserEvaluation::find($userEvaluationId);
        $responses = $this->responses[$userEvaluationId] ?? [];

        if (!$userEvaluation) {
            // Handle case where evaluation is not found
            session()->flash('error', 'Evaluation not found.');
            return;
        }

        // Loop through the responses and save them in the response_students table
        foreach ($responses as $questionId => $rating) {
            // Validate that a rating was provided
            if ($rating) {
                // Store the response in the response_students table
                Response::create([
                    'user_evaluation_id' => $userEvaluationId,
                    'question_id' => $questionId,
                    'rating' => $rating,
                ]);
            }
        }

        // Store comments if provided
        if (isset($this->comments[$userEvaluationId]) && $this->comments[$userEvaluationId]) {
            // Assuming you have a field for storing comments, if necessary
            $userEvaluation->update([
                'comment' => $this->comments[$userEvaluationId], // Assuming there's a comments column
            ]);
        }

        // Optionally mark the evaluation as completed
        $userEvaluation->update([
            'is_completed' => true,
            'evaluated_at' => now(), // Sets the current timestamp
        ]);        

        // Provide a success message
        session()->flash('success', 'Evaluation submitted successfully!');

        return redirect('/evaluation');
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Survey;
use App\Models\EvaluationResponse; // Assuming you have a model to store responses

class SurveyDisplay extends Component
{
    // public $survey;  // Store the survey data
    // public $responses = [];  // Array to hold the responses from the survey
    // public $surveyId = 1;

    // // Mount the survey data
    // public function mount($surveyId)
    // {
    //     $this->survey = Survey::with(['surveyRole', 'questionCriteria.questions'])->findOrFail($surveyId);
    // }

    // // Handle the form submission
    // public function submitSurvey()
    // {
    //     // Loop through the responses and store them
    //     foreach ($this->responses as $questionId => $rating) {
    //         // Save the response to the database
    //         EvaluationResponse::create([
    //             'question_id' => $questionId,
    //             'rating' => $rating,
    //             // Add any other required fields (e.g., user_id, survey_id, etc.)
    //         ]);
    //     }

    //     // Flash success message
    //     session()->flash('message', 'Survey submitted successfully!');
        
    //     // Optionally, clear the responses
    //     $this->responses = [];
    // }

    // public function render()
    // {
    //     return view('livewire.survey-display');
    // }
}

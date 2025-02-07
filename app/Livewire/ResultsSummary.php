<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Faculty;

class ResultsSummary extends Component
{   
    public $uuid;
    public $evaluationData = [];

    public function mount($uuid)
    {
        $this->uuid = $uuid;
        $this->loadEvaluationData();
    }
    
    public function render()
    {
        $faculty = $this->getFacultyByUuid($this->uuid);
        return view('livewire.results-summary', ['evaluationData' => $this->evaluationData], compact('faculty'));
    }

    protected function getFacultyByUuid($uuid)
    {
        // Return the faculty record along with its associated department
        return Faculty::with('facultyCourses')->where('uuid', $uuid)->first();
    }

    public function loadEvaluationData()
    {
        // Fetch the faculty data along with related models using eager loading.
        // The 'facultyCourses' relationship includes 'courseSection', 'studentEvaluations', 
        // 'responseStudents', 'question', and 'questionCriteria' relationships.
        $faculty = Faculty::with(['facultyCourses.courseSection.studentEvaluations.responseStudents.question.questionCriteria'])
            ->where('uuid', $this->uuid) // Filter by the faculty UUID
            ->first(); // Retrieve the first result (expecting only one faculty)
    
        // If no faculty is found, exit the function early.
        if (!$faculty) {
            return;
        }
    
        // Initialize empty arrays to store data and criteria questions
        $data = [];
        $criteriaQuestions = [];
    
        // Loop through each course that the faculty is teaching.
        foreach ($faculty->facultyCourses as $facultyCourse) {
            // Get the associated course section for each faculty course.
            $courseSection = $facultyCourse->courseSection;
            
            // Get the student evaluations for this course section, filtering for completed evaluations.
            $evaluations = $courseSection->studentEvaluations->where('is_completed', true);
    
            // Count the number of completed evaluations (N).
            $N = $evaluations->count();
    
            // Flatten the student evaluation responses, which are linked to multiple questions.
            $responses = $evaluations->flatMap->responseStudents;
            
            // Group the responses by question ID and calculate the average rating per question.
            // If there are no ratings, the result is 0.
            $questionRatings = $responses->groupBy('question_id')->map(fn($r) => $r->avg('rating') ?? 0);
    
            // Calculate the average rating for all questions (AVG) excluding null values.
            $AVG = $questionRatings->filter()->avg() ?? 0;
    
            // Loop through the responses to group the question codes by their respective criteria descriptions.
            foreach ($responses as $response) {
                $question = $response->question;
                // Store the question ID under its criteria description and question code.
                $criteriaQuestions[$question->questionCriteria->description][$question->questionCode] = $question->question_id;
            }
    
            // Append the evaluation data for this course section to the `$data` array.
            // Include course code, section name, the number of evaluations (N), ratings per question, and the overall average (AVG).
            $data[] = [
                'subject' => $courseSection->course->course_code,
                'section' => $courseSection->section->section_code,
                'N' => $N,
                'ratings' => $questionRatings,
                'AVG' => number_format($AVG, 2), // Format the average to 2 decimal places
            ];
        }
    
        // Store the final evaluation data and grouped criteria questions in the `$evaluationData` property.
        $this->evaluationData = ['data' => $data, 'criteriaQuestions' => $criteriaQuestions];
        // Uncomment the line below for debugging purposes to check the structure of the data.
        // dd($this->evaluationData);
    }    
}

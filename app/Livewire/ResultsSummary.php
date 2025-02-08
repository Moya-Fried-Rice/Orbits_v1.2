<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Faculty;
use App\Models\Role;

class ResultsSummary extends Component
{   
    public $uuid;
    public $evaluationData;

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
        $faculty = Faculty::with(['facultyCourses.courseSection.evaluations.userEvaluations.responses.question.questionCriteria'])
            ->where('uuid', $this->uuid)
            ->first();
    
        if (!$faculty) {
            return;
        }
    
        $groupedData = [];
        $criteriaQuestionsByRole = [];

        foreach ($faculty->facultyCourses as $facultyCourse) {
            $courseSection = $facultyCourse->courseSection;
            $sectionKey = $courseSection->course->course_code . '-' . $courseSection->section->section_code;

            foreach ($courseSection->evaluations as $evaluation) {
                foreach ($evaluation->userEvaluations as $userEvaluation) {
                    if (!$userEvaluation->is_completed) {
                        continue;
                    }

                    $role = $userEvaluation->user->role->role_name;  

                    $responses = $userEvaluation->responses;
                    $questionRatings = $responses->groupBy('question.question_code')
                        ->map(fn ($r) => $r->avg('rating') ?? 0);
                    $AVG = $questionRatings->filter()->avg() ?? 0;

                    foreach ($responses as $response) {
                        $question = $response->question;
                        $criteriaDesc = $question->questionCriteria->description;
                        $criteriaQuestionsByRole[$role][$criteriaDesc][$question->question_code] = $question->question_code;
                    }

                    // ✅ Aggregate ratings per section
                    if (!isset($groupedData[$role][$sectionKey])) {
                        $groupedData[$role][$sectionKey] = [
                            'subject' => $courseSection->course->course_code,
                            'section' => $courseSection->section->section_code,
                            'N' => 0,
                            'ratings' => [],
                            'AVG' => 0,
                        ];
                    }

                    // ✅ Merge ratings (sum and count for average calculation)
                    foreach ($questionRatings as $questionCode => $rating) {
                        $groupedData[$role][$sectionKey]['ratings'][$questionCode][] = $rating;
                    }

                    // ✅ Increase evaluation count (N)
                    $groupedData[$role][$sectionKey]['N'] += 1;
                }
            }
        }

        // ✅ Final processing: Compute actual averages
        foreach ($groupedData as $role => &$sections) {
            foreach ($sections as &$data) {
                $totalRatings = [];

                foreach ($data['ratings'] as $questionCode => $ratings) {
                    $avgRating = count($ratings) > 0 ? array_sum($ratings) / count($ratings) : 0;
                    $data['ratings'][$questionCode] = number_format($avgRating, 2);
                    $totalRatings[] = $avgRating;
                }

                // ✅ Compute section-wide average
                $data['AVG'] = count($totalRatings) > 0 ? number_format(array_sum($totalRatings) / count($totalRatings), 2) : '0.00';
            }
        }

        $this->evaluationData = [
            'data' => $groupedData,
            'criteriaQuestions' => $criteriaQuestionsByRole,
        ];


        // dd($this->evaluationData);

    }
}

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
        return Faculty::with('facultyCourses')
        ->whereHas('user', function ($query) use ($uuid) {
            $query->where('uuid', $uuid);
        })->first();
    }

    public function loadEvaluationData()
    {
        $faculty = $this->getFacultyWithEvaluations();
        if (!$faculty) {
            return;
        }

        $groupedData = [];
        $allRatings = []; // Store all ratings across all roles for overall average
        $criteriaRatings = []; // Store ratings grouped by criteria for radar chart
        $rolePercentages = [
            'student' => 0.50,
            'faculty' => 0.05,
            'self' => 0.05,
            'program_chair' => 0.40,
        ];

        // Store role-wise data separately
        $roleData = [];

        foreach ($faculty->facultyCourses as $facultyCourse) {
            $courseSection = $facultyCourse->courseSection;
            $sectionKey = $this->getSectionKey($courseSection);
            $completedEvaluations = $this->getCompletedEvaluationsByRole($courseSection);

            foreach ($courseSection->evaluations as $evaluation) {
                foreach ($evaluation->userEvaluations as $userEvaluation) {
                    if (!$userEvaluation->is_completed) {
                        continue;
                    }

                    $role = $userEvaluation->user->role->role_name;
                    $questionRatings = $this->getQuestionRatings($userEvaluation);

                    // Ensure "sections" key exists before storing data
                    if (!isset($groupedData[$role]['sections'][$sectionKey])) {
                        $groupedData[$role]['sections'][$sectionKey] = $this->initializeSectionData($courseSection, $completedEvaluations, $role);
                    }

                    $this->storeRatings($groupedData[$role]['sections'][$sectionKey]['ratings'], $questionRatings);

                    // Collect data for overall average and radar chart
                    foreach ($questionRatings as $criteriaAndQuestion => $rating) {
                        [$criteriaDesc, $questionCode] = explode('|', $criteriaAndQuestion);
                        
                        // Store for overall calculation
                        $allRatings[] = $rating;

                        // Store for criteria-based radar chart
                        $criteriaRatings[$criteriaDesc][] = $rating;
                    }
                }
            }
        }

        // Compute averages
        $this->computeFinalAverages($groupedData);

        // Compute average per criteria (for radar chart)
        $criteriaAverages = [];
        foreach ($criteriaRatings as $criteriaDesc => $ratings) {
            $criteriaAverages[$criteriaDesc] = count($ratings) > 0 ? number_format(array_sum($ratings) / count($ratings), 2) : '0.00';
        }

        // Calculate total and weighted average for each role
        foreach ($rolePercentages as $role => $percentage) {
            if (isset($groupedData[$role]['overall_avg'])) {
                $totalAvg = $groupedData[$role]['overall_avg'];
                
                // Ensure totalAvg is numeric before performing the calculation
                if (is_numeric($totalAvg)) {
                    $roleData[$role] = [
                        'percentage' => $percentage * 100, // Store percentage in whole number format
                        'total_avg' => $totalAvg,
                        'computed_avg' => number_format($totalAvg * $percentage, 2), // Weighted avg based on role percentage
                    ];
                } else {
                    // Handle case if 'overall_avg' is not numeric
                    $roleData[$role] = [
                        'percentage' => $percentage * 100,
                        'total_avg' => 'N/A',
                        'computed_avg' => 'N/A',
                    ];
                }
            }
        }

        // Compute the final weighted overall average using role percentages
        $finalOverallAvg = 0;
        foreach ($roleData as $data) {
            if (isset($data['computed_avg']) && is_numeric($data['computed_avg'])) {
                $finalOverallAvg += floatval($data['computed_avg']);
            }
        }

        // Format final overall average
        $finalOverallAvg = number_format($finalOverallAvg, 2);

        // Store the evaluation data
        $this->evaluationData = [
            'data' => $groupedData, // Keep grouped data inside "data"
            'final_overall_avg' => $finalOverallAvg, // Store final overall average outside "data"
            'criteria_avg' => $criteriaAverages, // Store criteria averages outside "data"
            'role_data' => $roleData, // Store the role-wise data
        ];

        // dd($this->evaluationData);
    }

    private function getFacultyWithEvaluations()
    {
        // 1. Retrieve faculty with related evaluations, user evaluations, and responses
        return Faculty::with([
            'facultyCourses.courseSection.evaluations.userEvaluations.responses.question.questionCriteria',
            'facultyCourses.courseSection.evaluations.userEvaluations.user.role' // Preload role
        ])
            ->whereHas('user', function ($query) {
                $query->where('uuid', $this->uuid);
            })
            ->first();
        
    }

    private function getSectionKey($courseSection)
    {
        // 1. Generate a unique key for the section using course and section codes
        return $courseSection->course->course_code . '-' . $courseSection->section->section_code;
    }

    private function getCompletedEvaluationsByRole($courseSection)
    {
        // 1. Flatten evaluations and filter only completed user evaluations
        return $courseSection->evaluations
            ->flatMap(fn ($evaluation) => $evaluation->userEvaluations)
            ->filter(fn ($userEvaluation) => $userEvaluation->is_completed)
            // 2. Group by evaluator role and count completed evaluations per role
            ->groupBy(fn ($userEvaluation) => $userEvaluation->user->role->role_name)
            ->map(fn ($evaluations) => $evaluations->count());
    }

    private function getQuestionRatings($userEvaluation)
    {
        // 1. Group responses by criteria description and question code
        return $userEvaluation->responses
            ->groupBy(fn ($r) => $r->question->questionCriteria->description . '|' . $r->question->question_code)
            // 2. Calculate the average rating for each question
            ->map(fn ($r) => $r->avg('rating') ?? 0);
    }

    private function initializeSectionData($courseSection, $completedEvaluations, $role)
    {
        // 1. Initialize section data with subject, section, and completed evaluations count
        return [
            'subject' => $courseSection->course->course_code,
            'section' => $courseSection->section->section_code,
            'N' => $completedEvaluations[$role] ?? 0,
            'ratings' => [],
            'AVG' => 0,
        ];
    }

    private function storeRatings(&$ratings, $questionRatings)
    {
        // 1. Iterate through question ratings and store them under their respective criteria
        foreach ($questionRatings as $criteriaAndQuestion => $rating) {
            [$criteriaDesc, $questionCode] = explode('|', $criteriaAndQuestion);
            $ratings[$criteriaDesc][$questionCode][] = $rating;
        }
    }

    private function computeFinalAverages(&$groupedData)
    {
        foreach ($groupedData as $role => &$roleData) {
            $totalRatings = [];
            $totalCount = 0;
    
            foreach ($roleData['sections'] as $sectionKey => &$data) {
                $sectionRatings = [];
    
                foreach ($data['ratings'] as &$questions) {
                    foreach ($questions as $questionCode => $ratings) {
                        $avgRating = count($ratings) > 0 ? array_sum($ratings) / count($ratings) : 0;
                        $questions[$questionCode] = number_format($avgRating, 2);
                        $sectionRatings[] = $avgRating;
                        $totalRatings[] = $avgRating;
                        $totalCount++;
                    }
                }
    
                $data['AVG'] = count($sectionRatings) > 0 ? number_format(array_sum($sectionRatings) / count($sectionRatings), 2) : '0.00';
            }
    
            // ✅ Store overall average outside "sections"
            if ($totalCount > 0) {
                $roleData['overall_avg'] = number_format(array_sum($totalRatings) / $totalCount, 2);
            }
        }
    }
    
}

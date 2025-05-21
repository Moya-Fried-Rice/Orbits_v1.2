<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Faculty;
// use App\Models\Role; // Role model might not be directly needed here unless for other logic
use Illuminate\Support\Facades\Http; // For HTTP requests
use Illuminate\Support\Facades\Log;  // For logging

class ResultsSummary extends Component
{   
    public $uuid;
    public $evaluationData;
    public $faculty; // To store loaded faculty data

    // Properties for sentiment analysis results
    public $positiveCommentCount = 0;
    public $negativeCommentCount = 0;
    public $positiveCommentsForView = [];
    public $negativeCommentsForView = [];
    public $positiveCommentAnalysis = []; // To store analysis for each positive comment
    public $negativeCommentAnalysis = []; // To store analysis for each negative comment


    public function mount($uuid)
    {
        $this->uuid = $uuid;
        $this->faculty = $this->getFacultyByUuid($this->uuid); // Load faculty once
        $this->loadEvaluationData(); // This will also trigger sentiment analysis
    }
    
    public function processSentimentAnalysis()
    {
        if (empty($this->evaluationData['comments_data'])) {
            $this->resetSentimentData(); // Reset if no comments
            return;
        }

        $apiUrl = config('services.sentiment_api.url'); // Use config helper

        if (!$apiUrl) {
            Log::error('Sentiment API URL is not configured. Please set SENTIMENT_API_URL in .env and config/services.php.');
            $this->resetSentimentData();
            return;
        }

        $allComments = $this->evaluationData['comments_data'];
        $tempPositiveComments = [];
        $tempNegativeComments = [];
        $tempPositiveAnalysis = []; // New array to store positive comment analysis
        $tempNegativeAnalysis = []; // New array to store negative comment analysis

        foreach ($allComments as $comment) {
            if (empty(trim($comment))) {
                continue; 
            }

            try {
                $response = Http::timeout(15)->post($apiUrl, [ // Increased timeout slightly
                    'text' => $comment,
                ]);

                if ($response->successful()) {
                    $sentimentResult = $response->json();
                    if (isset($sentimentResult['sentiment'])) {
                        $sentiment = strtolower($sentimentResult['sentiment']);
                        // Get the analysis comment if available
                        $analysis = isset($sentimentResult['comment']) ? $sentimentResult['comment'] : '';
                        
                        if ($sentiment === 'positive') {
                            $tempPositiveComments[] = $comment;
                            $tempPositiveAnalysis[] = $analysis;
                        } elseif ($sentiment === 'negative') {
                            $tempNegativeComments[] = $comment;
                            $tempNegativeAnalysis[] = $analysis;
                        } else { 
                            // Neutral or other unclassified sentiments are currently ignored for counts
                            Log::info('Neutral or unclassified sentiment for comment: ' . substr($comment, 0, 50) . '...');
                        }
                    } else {
                        Log::warning('Sentiment API response did not contain a sentiment key.', ['comment_start' => substr($comment, 0, 50), 'response' => $response->body()]);
                    }
                } else {
                    Log::error('Sentiment API request failed.', [
                        'comment_start' => substr($comment, 0, 50),
                        'status' => $response->status(),
                        'body' => $response->body(),
                    ]);
                }
            } catch (\Illuminate\Http\Client\ConnectionException $e) {
                Log::critical('Could not connect to Sentiment API: ' . $apiUrl . ' - ' . $e->getMessage());
                // Optionally, you could set a flag to show an error in the UI
                // For now, we'll stop processing further comments for this request if API is down
                $this->resetSentimentData(); // Reset to avoid showing partial/stale data
                // You might want to add a user-facing error message here if desired
                return; // Stop processing if API is down
            }  catch (\Exception $e) {
                Log::error('An unexpected error occurred during sentiment analysis.', ['comment_start' => substr($comment, 0, 50), 'error' => $e->getMessage()]);
            }
        }

        $this->positiveCommentsForView = $tempPositiveComments;
        $this->negativeCommentsForView = $tempNegativeComments;
        $this->positiveCommentAnalysis = $tempPositiveAnalysis; // Store positive comment analysis
        $this->negativeCommentAnalysis = $tempNegativeAnalysis; // Store negative comment analysis
        $this->positiveCommentCount = count($tempPositiveComments);
        $this->negativeCommentCount = count($tempNegativeComments);
    }

    private function resetSentimentData()
    {
        $this->positiveCommentCount = 0;
        $this->negativeCommentCount = 0;
        $this->positiveCommentsForView = [];
        $this->negativeCommentsForView = [];
        $this->positiveCommentAnalysis = []; // Clear positive comment analysis
        $this->negativeCommentAnalysis = []; // Clear negative comment analysis
    }

    public function render()
    {
        // $faculty is already loaded in mount
        // $evaluationData is already loaded in mount (and includes comments)
        // Sentiment analysis results are now public properties of this component.
        
        return view('livewire.results-summary', [
            'faculty' => $this->faculty, // Pass the loaded faculty
            'evaluationData' => $this->evaluationData,
            // The sentiment properties are automatically available in the Blade view
            // 'positiveCommentCount' => $this->positiveCommentCount,
            // 'negativeCommentCount' => $this->negativeCommentCount,
            // 'positiveCommentsForView' => $this->positiveCommentsForView,
            // 'negativeCommentsForView' => $this->negativeCommentsForView,
            'overall' => $this->evaluationData['final_overall_avg'] ?? 0,
        ]);
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
        $faculty = $this->getFacultyWithEvaluations(); // This uses $this->uuid
        if (!$faculty) {
            $this->evaluationData = [ /* sensible defaults or empty state */
                'data' => [],
                'final_overall_avg' => '0.00',
                'criteria_avg' => [],
                'role_data' => [],
                'comments_data' => [],
            ];
            $this->resetSentimentData();
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

        // Store comments
        $commentsData = []; // Store all comments

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
                    $comments = $userEvaluation->comment; // Assuming there's a 'comments' field

                    // Store comments
                    if ($comments) {
                        $commentsData[] = $comments;
                    }

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
            'comments_data' => $commentsData,
        ];
        
        // After loading all evaluation data including comments, process sentiments
        $this->processSentimentAnalysis();

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

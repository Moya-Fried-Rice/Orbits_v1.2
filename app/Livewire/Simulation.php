<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Evaluation;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\CourseSection;
use App\Models\FacultyCourse;
use App\Models\StudentCourse;
use App\Models\UserEvaluation;
use App\Models\Response;
use App\Models\Question;
use App\Models\QuestionCriteria;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;

class Simulation extends Component
{
    public $faculty_id;
    public $count = 1;

    public $student_id;
    public $student_count = 1;

    public $evaluation_count = 1; // Number of evaluations to complete
    public $isLoading = false; // Track loading state

    // Remove the random selection from mount
    public function mount()
    {
        // Set only initial values (if needed)
        $this->faculty_id = null;
        $this->student_id = null;
    }

    // Create random course sections for faculty with new faculty_id
    public function createRandomCourseSections()
    {
        $this->isLoading = true; // Set loading state to true

        try {
            // Assign a random faculty_id each time the button is clicked
            $this->faculty_id = Faculty::inRandomOrder()->first()->faculty_id ?? null;

            if (!$this->faculty_id || $this->count < 1) return;
        
            $assignedSectionIds = FacultyCourse::where('faculty_id', $this->faculty_id)
                ->pluck('course_section_id')
                ->toArray();
        
            $courseSections = CourseSection::whereNotIn('course_section_id', $assignedSectionIds)
                ->inRandomOrder()
                ->take($this->count)
                ->get();
        
            foreach ($courseSections as $section) {
                FacultyCourse::create([
                    'course_section_id' => $section->course_section_id,
                    'faculty_id' => $this->faculty_id,
                ]);
            }
        
            session()->flash('message', "{$courseSections->count()} unique course section(s) assigned to the faculty.");
        } catch (QueryException $e) {
            Log::error("Database query error while assigning course sections to faculty: " . $e->getMessage());
            session()->flash('error', "A database error occurred while assigning course sections to the faculty.");
        } catch (Exception $e) {
            Log::error("Unexpected error while assigning course sections to faculty: " . $e->getMessage());
            session()->flash('error', "An unexpected error occurred while assigning course sections to the faculty.");
        }

        $this->isLoading = false; // Set loading state to false after completion
    }

    // Create random course sections for student with new student_id
    public function createRandomCourseSectionsForStudent()
    {
        $this->isLoading = true; // Set loading state to true

        try {
            // Assign a random student_id each time the button is clicked
            $this->student_id = Student::inRandomOrder()->first()->student_id ?? null;
        
            if (!$this->student_id || $this->student_count < 1) return;
            
            // Select only evaluations with survey_id = 1
            $courseSectionIds = Evaluation::where('survey_id', 1)  // Add the where clause
                ->select('course_section_id')
                ->distinct()
                ->inRandomOrder()
                ->limit($this->student_count)
                ->pluck('course_section_id');
            
            foreach ($courseSectionIds as $courseSectionId) {
                StudentCourse::firstOrCreate([
                    'course_section_id' => $courseSectionId,
                    'student_id' => $this->student_id,
                ]);
            }
        
            session()->flash('message', "{$courseSectionIds->count()} course section(s) from evaluations with survey_id = 1 assigned to the student.");
        } catch (QueryException $e) {
            Log::error("Database query error while assigning course sections to student: " . $e->getMessage());
            session()->flash('error', "A database error occurred while assigning course sections to the student.");
        } catch (Exception $e) {
            Log::error("Unexpected error while assigning course sections to student: " . $e->getMessage());
            session()->flash('error', "An unexpected error occurred while assigning course sections to the student.");
        }

        $this->isLoading = false; // Set loading state to false after completion
    }

    private function getRandomComment(): string
    {
        $comments = [
            'Great teaching approach.',
            'Needs improvement in communication.',
            'Very detailed and organized.',
            'Lacks student engagement.',
            'Clearly explains difficult topics.',
            'Often unprepared for class.',
            'Gives constructive feedback.',
            'Strict but fair.',
            'Supportive and approachable.',
            'Could improve time management.',
        ];

        return $comments[array_rand($comments)];
    }

    // Function to complete random evaluations and add random responses
    public function completeRandomEvaluations()
    {
        $this->isLoading = true; // Set loading state to true

        try {
            if ($this->evaluation_count < 1) return;

            // Select random user evaluations that are not yet completed
            $userEvaluations = UserEvaluation::where('is_completed', false)
                ->inRandomOrder()
                ->take($this->evaluation_count)
                ->get();

            foreach ($userEvaluations as $userEvaluation) {

                $randomTime = Carbon::now()->subDays(rand(1, 30))->toDateTimeString();

                // Mark as completed
                $userEvaluation->update([
                    'is_completed' => true,
                    'evaluated_at' => $randomTime,
                    'comment' => $this->getRandomComment(),
                ]);

                // Get the survey ID for this evaluation
                $surveyId = Evaluation::find($userEvaluation->evaluation_id)->survey_id;

                // Get all the criteria related to the survey
                $criteria = QuestionCriteria::where('survey_id', $surveyId)->get();

                foreach ($criteria as $criterion) {
                    // Get all questions related to this criterion
                    $questions = Question::where('criteria_id', $criterion->criteria_id)->get();

                    foreach ($questions as $question) {
                        // Generate a random rating between 1 and 5
                        $rating = rand(1, 5);

                        // Add a random response to the responses table
                        Response::create([
                            'user_evaluation_id' => $userEvaluation->user_evaluation_id,
                            'question_id' => $question->question_id,
                            'rating' => $rating,
                        ]);
                    }
                }
            }

            session()->flash('message', "{$userEvaluations->count()} evaluation(s) completed and responses added.");
        } catch (QueryException $e) {
            Log::error("Database query error while completing evaluations: " . $e->getMessage());
            session()->flash('error', "A database error occurred while completing the evaluations and adding responses.");
        } catch (ValidationException $e) {
            Log::error("Validation error while completing evaluations: " . $e->getMessage());
            session()->flash('error', "A validation error occurred while completing the evaluations and adding responses.");
        } catch (Exception $e) {
            Log::error("Unexpected error while completing evaluations: " . $e->getMessage());
            session()->flash('error', "An unexpected error occurred while completing the evaluations and adding responses.");
        }

        $this->isLoading = false; // Set loading state to false after completion
    }

    public function render()
    {
        return view('livewire.simulation');
    }
}

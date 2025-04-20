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
    public $faculty_total = 1;
    public $faculty_section_count = 1;

    public $student_total = 1;
    public $student_section_count = 1;

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

    public function createRandomCourseSections()
    {
        $this->isLoading = true;

        try {
            if ($this->faculty_total < 1 || $this->faculty_section_count < 1) return;

            $faculties = Faculty::inRandomOrder()->take($this->faculty_total)->get();
            $assigned = 0;

            foreach ($faculties as $faculty) {
                $assignedSectionIds = FacultyCourse::where('faculty_id', $faculty->faculty_id)
                    ->pluck('course_section_id')
                    ->toArray();

                $availableSections = CourseSection::whereNotIn('course_section_id', $assignedSectionIds)
                    ->inRandomOrder()
                    ->take($this->faculty_section_count)
                    ->get();

                foreach ($availableSections as $section) {
                    FacultyCourse::create([
                        'course_section_id' => $section->course_section_id,
                        'faculty_id' => $faculty->faculty_id,
                    ]);
                    $assigned++;
                }
            }

            session()->flash('message', "{$assigned} course section(s) assigned across {$faculties->count()} faculty member(s).");
        } catch (Exception $e) {
            Log::error("Error in faculty simulation: " . $e->getMessage());
            session()->flash('error', "An error occurred while simulating faculty course sections.");
        }

        $this->isLoading = false;
    }

    public function createRandomCourseSectionsForStudent()
    {
        $this->isLoading = true;

        try {
            if ($this->student_total < 1 || $this->student_section_count < 1) return;

            $students = Student::inRandomOrder()->take($this->student_total)->get();
            $assigned = 0;

            foreach ($students as $student) {
                $courseSectionIds = Evaluation::where('survey_id', 1)
                    ->select('course_section_id')
                    ->distinct()
                    ->inRandomOrder()
                    ->limit($this->student_section_count)
                    ->pluck('course_section_id');

                foreach ($courseSectionIds as $courseSectionId) {
                    StudentCourse::firstOrCreate([
                        'course_section_id' => $courseSectionId,
                        'student_id' => $student->student_id,
                    ]);
                    $assigned++;
                }
            }

            session()->flash('message', "{$assigned} course section(s) assigned across {$students->count()} student(s).");
        } catch (Exception $e) {
            Log::error("Error in student simulation: " . $e->getMessage());
            session()->flash('error', "An error occurred while simulating student course sections.");
        }

        $this->isLoading = false;
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

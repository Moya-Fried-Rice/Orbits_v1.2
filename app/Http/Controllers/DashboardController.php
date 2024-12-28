<?php

// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\CourseSection;
use App\Models\Course;
use App\Models\Department;
use App\Models\EvaluationPeriod;
use App\Models\ProgramChair;
use App\Models\ProgramCourse;
use App\Models\Question;
use App\Models\QuestionCriteria;
use App\Models\StudentCourse;
use App\Models\Survey;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the dashboard with all data.
     */
    public function index()
    {
        // Fetch data from the database
        $programs = Program::all(); // All programs
        $faculties = Faculty::all(); // All faculties
        $students = Student::all(); // All students
        $courseSections = CourseSection::all(); // All course sections
        $courses = Course::all(); // All course
        $departments = Department::all(); // All departments
        $evaluationPeriods = EvaluationPeriod::all(); // All evaluation periods
        $programChairs = ProgramChair::all(); // All program chairs
        $programCourses = ProgramCourse::all(); // All program courses
        $questions = Question::all(); // All questions
        $questionCriterias = QuestionCriteria::all(); // All question criteria
        $studentCourses = StudentCourse::all(); // All student courses
        $surveys = Survey::all(); // All surveys

        // Pass the data to the view
        return view('dashboard.admin_dashboard', compact(
            'programs', 'faculties', 'students', 'courseSections', 'departments', 
            'evaluationPeriods', 'programChairs', 'programCourses', 'questions', 
            'questionCriterias', 'studentCourses', 'surveys', 'courses'
        ));
    }
}

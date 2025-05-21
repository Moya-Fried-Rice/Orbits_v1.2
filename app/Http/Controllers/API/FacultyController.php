<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\FacultyCourse;
use App\Models\UserEvaluation;
use App\Models\CourseSection;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacultyController extends Controller
{
    /**
     * Get faculty evaluation details
     * 
     * @param int $id Faculty ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEvaluationDetails($id)
    {
        // Get faculty data
        $faculty = Faculty::with('department', 'user')
            ->findOrFail($id);
        
        // Get all course sections taught by this faculty
        $facultySections = FacultyCourse::where('faculty_id', $id)
            ->with(['courseSection.course', 'courseSection.section'])
            ->get();
        
        $totalSections = $facultySections->count();
        $completedSections = 0;
        $inProgressSections = 0;
        $totalEvaluations = 0;
        $completedEvaluations = 0;
        $sectionDetails = [];
        
        foreach ($facultySections as $facultySection) {
            $courseSection = $facultySection->courseSection;
            
            if ($courseSection) {
                $course = $courseSection->course;
                $section = $courseSection->section;
                
                // Count evaluations for this section
                $sectionEvaluations = UserEvaluation::join('evaluations', 'user_evaluations.evaluation_id', '=', 'evaluations.evaluation_id')
                    ->where('evaluations.course_section_id', $courseSection->course_section_id)
                    ->count();
                
                $sectionCompletedEvaluations = UserEvaluation::join('evaluations', 'user_evaluations.evaluation_id', '=', 'evaluations.evaluation_id')
                    ->where('evaluations.course_section_id', $courseSection->course_section_id)
                    ->where('user_evaluations.is_completed', true)
                    ->count();
                
                $completionRate = $sectionEvaluations > 0 ? ($sectionCompletedEvaluations / $sectionEvaluations) * 100 : 0;
                
                // Determine status
                $status = 'Not Started';
                if ($sectionEvaluations > 0) {
                    if ($sectionCompletedEvaluations >= $sectionEvaluations) {
                        $status = 'Completed';
                        $completedSections++;
                    } else {
                        $status = 'In Progress';
                        $inProgressSections++;
                    }
                }
                
                // Accumulate totals
                $totalEvaluations += $sectionEvaluations;
                $completedEvaluations += $sectionCompletedEvaluations;
                
                // Add to section details array
                $sectionDetails[] = [
                    'course_id' => $course->course_id,
                    'course_code' => $course->course_code,
                    'course_name' => $course->course_name,
                    'section_id' => $section ? $section->section_id : null,
                    'section_code' => $section ? $section->section_code : 'Unknown',
                    'status' => $status,
                    'completion_rate' => $completionRate,
                    'total_evaluations' => $sectionEvaluations,
                    'completed_evaluations' => $sectionCompletedEvaluations,
                ];
            }
        }
        
        // Calculate overall completion rate
        $overallCompletion = $totalEvaluations > 0 ? ($completedEvaluations / $totalEvaluations) * 100 : 0;
        
        return response()->json([
            'faculty_id' => $faculty->faculty_id,
            'faculty_name' => $faculty->user ? $faculty->user->first_name . ' ' . $faculty->user->last_name : 'Unknown',
            'department' => $faculty->department ? $faculty->department->department_name : 'Unknown Department',
            'department_code' => $faculty->department ? $faculty->department->department_code : 'N/A',
            'total_sections' => $totalSections,
            'completed_sections' => $completedSections,
            'in_progress_sections' => $inProgressSections,
            'not_started_sections' => $totalSections - ($completedSections + $inProgressSections),
            'overall_completion' => $overallCompletion,
            'total_evaluations' => $totalEvaluations,
            'completed_evaluations' => $completedEvaluations,
            'sections' => $sectionDetails,
        ]);
    }
}

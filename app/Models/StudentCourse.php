<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentCourse extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'student_courses';
    protected $primaryKey = 'student_course_id';
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'course_section_id',
    ];

    // Define relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function courseSection()
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }

    // Boot method to handle create, delete, and restore events
    protected static function booted()
    {
        // Create a UserEvaluation record when a StudentCourse is created
        static::created(function ($studentCourse) {
            // Retrieve all evaluations where the survey has a role_id of 1
            $evaluations = Evaluation::whereHas('survey.surveyRoles', function ($query) {
                $query->where('role_id', '1');
            })->where('course_section_id', $studentCourse->course_section_id)
              ->get(); // Ensure it matches the student's course section
    
            // Loop through each evaluation and create a UserEvaluation
            foreach ($evaluations as $evaluation) {
                UserEvaluation::create([
                    'evaluation_id' => $evaluation->evaluation_id, // Assign correct evaluation_id
                    'user_id' => $studentCourse->student->user_id,
                    'is_completed' => false,
                    'evaluated_at' => null,
                ]);
            }
        });
    
        // Delete related UserEvaluation records when a StudentCourse is deleted
        static::deleted(function ($studentCourse) {
            UserEvaluation::where('user_id', $studentCourse->student->user_id)
                ->whereHas('evaluation', function ($query) use ($studentCourse) {
                    $query->where('course_section_id', $studentCourse->course_section_id)
                          ->whereHas('survey.surveyRoles', function ($roleQuery) {
                              $roleQuery->where('role_id', '1');
                          });
                })->delete();
        });
    
        // Restore corresponding UserEvaluation records when a StudentCourse is restored
        static::restored(function ($studentCourse) {
            // Retrieve all evaluations where the survey has a role_id of 1
            $evaluations = Evaluation::whereHas('survey.surveyRoles', function ($query) {
                $query->where('role_id', '1');
            })->where('course_section_id', $studentCourse->course_section_id)
              ->get();
    
            // Loop through each evaluation and recreate UserEvaluation
            foreach ($evaluations as $evaluation) {
                UserEvaluation::create([
                    'evaluation_id' => $evaluation->evaluation_id,
                    'user_id' => $studentCourse->student->user_id,
                    'is_completed' => false,
                    'evaluated_at' => null,
                ]);
            }
        });
    }    
}

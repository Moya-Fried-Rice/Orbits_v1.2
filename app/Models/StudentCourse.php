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
        // Create a StudentEvaluation record when a StudentCourse is created
        static::created(function ($studentCourse) {
            // Retrieve all survey_roles where the role is 'student' and the course_section_id matches
            $surveyRoles = SurveyRole::where('role_id', '1')->get(); // Retrieve all matching roles

            // Loop through each survey role and create a StudentEvaluation
            foreach ($surveyRoles as $surveyRole) {
                StudentEvaluation::create([
                    'student_id' => $studentCourse->student_id,
                    'course_section_id' => $studentCourse->course_section_id,
                    'survey_id' => $surveyRole->survey_id, // Insert the survey_id from the SurveyRole
                    'is_completed' => false,
                    'evaluated_at' => null,
                ]);
            }
        });

        // Delete the related StudentEvaluation record when a StudentCourse is deleted
        static::deleted(function ($studentCourse) {
            StudentEvaluation::where('student_id', $studentCourse->student_id)
                ->where('course_section_id', $studentCourse->course_section_id)
                ->delete();
        });

        // Restore the corresponding StudentEvaluation when a StudentCourse is restored
        static::restored(function ($studentCourse) {
            // Retrieve all survey_roles where the role is 'student' and the course_section_id matches
            $surveyRoles = SurveyRole::where('role_id', '1')->get(); // Retrieve all matching roles

            // Loop through each survey role and recreate the StudentEvaluation
            foreach ($surveyRoles as $surveyRole) {
                StudentEvaluation::create([
                    'student_id' => $studentCourse->student_id,
                    'course_section_id' => $studentCourse->course_section_id,
                    'survey_id' => $surveyRole->survey_id, // Insert the survey_id from the SurveyRole
                    'is_completed' => false,
                    'evaluated_at' => null,
                ]);
            }
        });
    }   
}

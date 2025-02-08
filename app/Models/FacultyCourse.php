<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacultyCourse extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'faculty_courses';
    protected $primaryKey = 'faculty_course_id';
    public $timestamps = false;

    protected $fillable = [
        'faculty_id',
        'course_section_id',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public function courseSection()
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }

    protected static function booted()
    {
        // Create a Evaluation record when a FacultyCourse is created
        static::created(function ($facultyCourse) {
            // Retrieve all survey
            $surveys = Survey::all(); 

            // Loop through each survey
            foreach ($surveys as $survey) {
                Evaluation::create([
                    'course_section_id' => $facultyCourse->course_section_id,
                    'survey_id' => $survey->survey_id, // Use the survey assigned to self-evaluations
                ]);
            }
        });

        // Delete the related Evaluation record when a FacultyCourse is deleted
        static::deleted(function ($facultyCourse) {
            Evaluation::where('course_section_id', $facultyCourse->course_section_id)->delete();
        });

        // Restore the corresponding Evaluation when a FacultyCourse is restored
        static::restored(function ($facultyCourse) {
            // Retrieve all survey roles where the role is 'self' (assuming role_id = 2)
            $surveys = Survey::all(); 

            // Loop through each survey role and recreate the Evaluation
            foreach ($surveys as $surveyRole) {
                Evaluation::create([
                    'course_section_id' => $facultyCourse->course_section_id,
                    'survey_id' => $surveyRole->survey_id,
                ]);
            }
        });
    }

}

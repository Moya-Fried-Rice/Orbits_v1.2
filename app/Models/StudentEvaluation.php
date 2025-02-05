<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentEvaluation extends Model
{
    protected $table = 'student_evaluations';
    protected $primaryKey = 'student_evaluation_id';
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'course_section_id',
        'comment',
        'survey_id',
        'is_completed',
        'evaluated_at'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function courseSection()
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }
}

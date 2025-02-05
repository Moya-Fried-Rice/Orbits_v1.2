<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseSection extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'course_sections';
    protected $primaryKey = 'course_section_id';
    public $timestamps = true;

    protected $fillable = [
        'course_id',
        'section_id',
        'faculty_id',
    ];

    public function studentCourse()
    {
        return $this->hasMany(StudentCourse::class, 'course_section_id', 'course_section_id'); 
    }

    public function studentEvaluation()
    {
        return $this->hasMany(StudentEvaluation::class, 'course_section_id', 'course_section_id'); 
    }

    public function facultyCourse()
    {
        return $this->hasMany(FacultyCourse::class, 'course_section_id', 'course_section_id'); 
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }




















    
    // public function evaluationPeriod()
    // {
    //     return $this->belongsTo(EvaluationPeriod::class, 'period_id', 'period_id');
    // }
    
}

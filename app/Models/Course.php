<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'courses';
    protected $primaryKey = 'course_id';
    public $timestamps = true;

    protected $fillable = [
        'course_name',
        'course_description',
        'course_code',
        'department_id',
        'lab',
        'lec',
    ];

    public function getUnitsAttribute()
    {
        return $this->lab + $this->lec;
    }

    public function courseSections()
    {
        return $this->hasMany(CourseSection::class, 'course_id', 'course_id');
    }

    public function programCourses()
    {
        return $this->hasMany(ProgramCourse::class, 'course_id', 'course_id');
    }

    public function getTotalEvaluatedAttribute()
    {
        return $this->courseSections()->withCount('studentEvaluation')->get()->sum('student_evaluation_count');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }
}

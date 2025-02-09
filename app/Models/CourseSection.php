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

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'course_section_id', 'course_section_id'); 
    }

    public function facultyCourses()
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

    public function totalEvaluated($role)
    {
        $evaluationIds = $this->evaluations()->pluck('evaluation_id'); // Fetch evaluation IDs first
    
        return UserEvaluation::whereIn('evaluation_id', $evaluationIds)
            ->whereHas('user.role', function ($query) use ($role) { // Directly access `role` relationship
                $query->where('role_name', $role); // Change 'role_name' if your column is different
            })
            ->where('is_completed', true)
            ->count();
    }     
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseSection extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Define the table name (optional if it follows Laravel's convention)
    protected $table = 'course_sections';

    // Define the primary key (optional if it follows Laravel's convention)
    protected $primaryKey = 'course_section_id';

    // Disable timestamps if you're not using created_at and updated_at fields
    public $timestamps = true;

    // Define the fillable attributes (to prevent mass assignment issues)
    protected $fillable = [
        'course_id',
        'section',
        'period_id',
        'faculty_id',
        'program_id',
    ];


    // Define the relationship with EvaluationPeriod model
    public function evaluationPeriod()
    {
        return $this->belongsTo(EvaluationPeriod::class, 'period_id', 'period_id');
    }

    // Define the relationship with Student model through the pivot table
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_courses', 'course_section_id', 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    // Define the program relationship
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    // Define the faculty relationship
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }
    
}

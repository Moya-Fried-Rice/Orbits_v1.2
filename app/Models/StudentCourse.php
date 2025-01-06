<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentCourse extends Pivot
{
    use HasFactory;
    use SoftDeletes;

    // Define the table name (optional if it follows Laravel's convention)
    protected $table = 'student_courses';

    // Disable timestamps if you're not using created_at and updated_at fields
    public $timestamps = true;

    // Define the fillable attributes (to prevent mass assignment issues)
    protected $fillable = [
        'student_id',
        'course_section_id',
    ];

    // Define any relationships here, if needed
    // If you want to access the related student or course section:
    
    // Relationship with Student model
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    // Relationship with CourseSection model
    public function courseSection()
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id', 'course_section_id');
    }
}

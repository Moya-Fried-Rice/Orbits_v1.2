<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCourse extends Model
{
    use HasFactory;

    // Define the table name
    protected $table = 'student_courses';

    // Define the primary key (if it's not the default 'id')
    protected $primaryKey = 'student_course_id';

    // If you don't want timestamps (created_at, updated_at), set to false
    public $timestamps = false;

    // Define the fillable fields for mass assignment
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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // Define the table name (optional if it follows Laravel's convention)
    protected $table = 'courses';

    // Define the primary key (optional if it follows Laravel's convention)
    protected $primaryKey = 'course_id';

    // Disable timestamps if you're not using created_at and updated_at fields
    public $timestamps = true;

    // Define the fillable attributes (to prevent mass assignment issues)
    protected $fillable = [
        'course_name',
        'course_description',
        'course_code',
        'department_id', // Foreign key referencing departments table
    ];

    // Define the relationship with Department model
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    // Define the relationship with CourseSection model
    public function courseSections()
    {
        return $this->hasMany(CourseSection::class, 'course_id', 'course_id');
    }
}

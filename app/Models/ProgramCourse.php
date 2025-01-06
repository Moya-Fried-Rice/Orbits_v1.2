<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramCourse extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Define the table name (optional if it follows Laravel's convention)
    protected $table = 'program_courses';

    // Define the primary key (optional if it follows Laravel's convention)
    protected $primaryKey = 'id'; // Assuming `id` is the primary key for this pivot table

    // Disable timestamps if you're not using created_at and updated_at fields
    public $timestamps = true;

    // Define the fillable attributes (to prevent mass assignment issues)
    protected $fillable = [
        'program_id',
        'course_id',
    ];

    // Define the relationships (if any)

    // Define the relationship with the Program model (ProgramCourse belongs to Program)
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'program_id');
    }

    // Define the relationship with the Course model (ProgramCourse belongs to Course)
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }
}

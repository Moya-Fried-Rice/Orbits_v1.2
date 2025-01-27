<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramCourse extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'program_courses';
    protected $primaryKey = 'program_course_id';
    public $timestamps = false;

    protected $fillable = [
        'program_id',
        'course_id',
        'year_level',
        'semester',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}

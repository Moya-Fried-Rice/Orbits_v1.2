<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacultyCourse extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'faculty_courses';
    protected $primaryKey = 'faculty_course_id';
    public $timestamps = false;

    protected $fillable = [
        'faculty_id',
        'course_section_id',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public function courseSection()
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }
}

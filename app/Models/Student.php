<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'students';
    protected $primaryKey = 'student_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'program_id',
        'phone_number',
        'profile_image',
    ];

    public function getStudentNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function studentCourses()
    {
        return $this->hasMany(StudentCourse::class, 'student_id', 'student_id'); 
    }

    public function studentEvaluations()
    {
        return $this->hasMany(StudentEvaluation::class, 'student_id', 'student_id'); 
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'program_id');
    }
}

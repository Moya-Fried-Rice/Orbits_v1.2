<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    // Define the table name (optional if it follows Laravel's convention)
    protected $table = 'students';

    // Define the primary key (optional if it follows Laravel's convention)
    protected $primaryKey = 'student_id'; // Assuming student_id is the primary key

    // Enable timestamps (default behavior)
    public $timestamps = true;

    // Define the fillable attributes (to prevent mass assignment issues)
    protected $fillable = [
        'uuid',
        'user_id',
        'first_name',
        'last_name',
        'program_id',
        'phone_number',
        'profile_image',
    ];

    // Define the relationships (if any)

    // Relationship with Program model (Student belongs to a Program)
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'program_id');
    }

    // Many-to-many relationship with CourseSection model (Student has many CourseSections)
    public function courseSections()
    {
        return $this->belongsToMany(CourseSection::class, 'student_courses', 'student_id', 'course_section_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Custom password setter (for hashing)
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value); // Automatically hash password before saving
    }

    // Hide sensitive data from serialization
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Get the attributes that should be cast
    protected function casts(): array
    {
        return [
            'password' => 'hashed', // Ensure password is always hashed
        ];
    }
}

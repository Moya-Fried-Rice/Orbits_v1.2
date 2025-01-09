<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Student extends Model implements Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    use AuthenticatableTrait; // Add this trait to handle authentication

    // Define the table name (optional if it follows Laravel's convention)
    protected $table = 'students';

    // Define the primary key (optional if it follows Laravel's convention)
    protected $primaryKey = 'student_id'; // Assuming student_id is the primary key

    // Disable timestamps if you're not using created_at and updated_at fields
    public $timestamps = true;

    // Define the fillable attributes (to prevent mass assignment issues)
    protected $fillable = [
        'username',
        'password',
        'email',
        'first_name',
        'last_name',
        'program_id',
        'phone_number',
        'profile_image',
    ];

    // Define the relationships (if any)

    // Define the relationship with the Program model (Student belongs to a Program)
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'program_id');
    }

    // Define the relationship with the CourseSection model (Student has many CourseSections)
    public function courseSections()
    {
        return $this->belongsToMany(CourseSection::class, 'student_courses', 'student_id', 'course_section_id');
    }

    // Custom password setter (for hashing)
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value); // Automatically hash password before saving
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faculty extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    // Define the table name (optional if it follows Laravel's convention)
    protected $table = 'faculties';

    // Define the primary key (optional if it follows Laravel's convention)
    protected $primaryKey = 'faculty_id';

    // Enable timestamps (default behavior)
    public $timestamps = true;

    // Define the fillable attributes (to prevent mass assignment issues)
    protected $fillable = [
        'username',
        'password',
        'email',
        'first_name',
        'last_name',
        'department_id',
        'phone_number',
        'profile_image',
    ];

    // Define the relationships (if any)

    // Relationship with Department model (Faculty belongs to Department)
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    // Many-to-many relationship with CourseSection (Faculty can teach many course sections)
    public function courseSections()
    {
        return $this->belongsToMany(CourseSection::class, 'faculty_courses', 'faculty_id', 'course_section_id');
    }

    // Relationship with PeerEvaluation (Faculty can be evaluated by peers)
    public function peerEvaluations()
    {
        return $this->hasMany(PeerEvaluation::class, 'faculty_id', 'faculty_id');
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

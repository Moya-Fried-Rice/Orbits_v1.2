<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Faculty extends Model implements Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    use AuthenticatableTrait; // Add this trait to handle authentication

    // Define the table name (optional if it follows Laravel's convention)
    protected $table = 'faculties';

    // Define the primary key (optional if it follows Laravel's convention)
    protected $primaryKey = 'faculty_id';

    // Disable timestamps if you're not using created_at and updated_at fields
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

    // Define the relationship with the Department model (Faculty belongs to Department)
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    // Define the many-to-many relationship with CourseSection (Faculty can teach many course sections)
    public function courseSections()
    {
        return $this->belongsToMany(CourseSection::class, 'faculty_courses', 'faculty_id', 'course_section_id');
    }

    // Define the relationship with PeerEvaluation (Faculty can be evaluated by peers)
    public function peerEvaluations()
    {
        return $this->hasMany(PeerEvaluation::class, 'faculty_id', 'faculty_id');
    }

    // Custom password setter (for hashing)
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value); // Automatically hash password before saving
    }
}

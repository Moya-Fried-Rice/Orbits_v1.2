<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramChair extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    // Define the table name (optional if it follows Laravel's convention)
    protected $table = 'program_chairs';

    // Define the primary key (optional if it follows Laravel's convention)
    protected $primaryKey = 'chair_id';

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
        'profile_image',
    ];

    // Define the relationships (if any)

    // Relationship with Department model (ProgramChair belongs to Department)
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    // Relationship with Programs (ProgramChair can have many programs)
    public function programs()
    {
        return $this->hasMany(Program::class, 'department_id', 'department_id');
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

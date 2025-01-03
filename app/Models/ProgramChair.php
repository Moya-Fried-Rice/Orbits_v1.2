<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramChair extends Model
{
    use HasFactory;

    // Define the table name (optional if it follows Laravel's convention)
    protected $table = 'program_chairs';

    // Define the primary key (optional if it follows Laravel's convention)
    protected $primaryKey = 'chair_id';

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
        'profile_image',
    ];

    // Define the relationships (if any)

    // Define the relationship with the Department model (ProgramChair belongs to Department)
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    // Define the relationship with Programs (ProgramChair can have many programs)
    public function programs()
    {
        return $this->hasMany(Program::class, 'department_id', 'department_id');
    }

    // You can define any custom methods or additional relationships here
}
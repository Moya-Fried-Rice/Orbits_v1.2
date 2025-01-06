<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Define the table name (optional if it follows Laravel's convention)
    protected $table = 'departments';

    // Define the primary key (optional if it follows Laravel's convention)
    protected $primaryKey = 'department_id';

    // Disable timestamps if you're not using created_at and updated_at fields
    public $timestamps = true;

    // Define the fillable attributes (to prevent mass assignment issues)
    protected $fillable = [
        'department_name',
        'department_description',
        'department_code',
    ];

    // Define the relationship with Course model
    public function courses()
    {
        return $this->hasMany(Course::class, 'department_id', 'department_id');
    }

    // Define the relationship with Faculty model
    public function faculties()
    {
        return $this->hasMany(Faculty::class, 'department_id', 'department_id');
    }

    // Define the relationship with Program model
    public function programs()
    {
        return $this->hasMany(Program::class, 'department_id', 'department_id');
    }

    // Define the relationship with ProgramChair model
    public function programChairs()
    {
        return $this->hasMany(ProgramChair::class, 'department_id', 'department_id');
    }
}

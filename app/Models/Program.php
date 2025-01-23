<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Define the table name (optional if it follows Laravel's convention)
    protected $table = 'programs';

    // Define the primary key (optional if it follows Laravel's convention)
    protected $primaryKey = 'program_id';

    // Disable timestamps if you're not using created_at and updated_at fields
    public $timestamps = true;

    // Define the fillable attributes (to prevent mass assignment issues)
    protected $fillable = [
        'program_code',
        'program_name',
        'abbreviation',
        'program_description',
        'department_id',
    ];

    // Define the relationships (if any)

    // Define the relationship with the Department model (Program belongs to Department)
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    // Define the many-to-many relationship with Courses (Programs can have many courses)
    public function course()
    {
        return $this->belongsToMany(Course::class, 'course_program', 'program_id', 'course_id')
                    ->withTimestamps();
    }

    // Define the relationship with the Student model (Program has many students)
    public function student()
    {
        return $this->hasMany(Student::class, 'program_id', 'program_id');
    }

    public function program()
    {
        return $this->hasMany(Student::class, 'course_section_id', 'course_section_id');
    }

    // You can define any custom methods or additional relationships here
}

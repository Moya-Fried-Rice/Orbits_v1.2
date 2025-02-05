<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'programs';
    protected $primaryKey = 'program_id';
    public $timestamps = true;

    protected $fillable = [
        'program_code',
        'program_name',
        'abbreviation',
        'program_description',
        'department_id',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'program_id', 'program_id');
    }

    public function programCourses()
    {
        return $this->hasMany(ProgramCourse::class, 'program_id', 'program_id');
    }
    
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }
}

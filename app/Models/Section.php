<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    // Specify the primary key if it's not the default 'id'
    protected $primaryKey = 'section_id';

    // Allow mass assignment for specific fields
    protected $fillable = [
        'section_id',
        'year_level',
        'section_number',
        'program_id',
        'period_id',
    ];

    /**
     * Relationship with Program
     * Each section belongs to one program.
     */
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'program_id');
    }

    /**
     * Relationship with EvaluationPeriod
     * Each section belongs to one evaluation period.
     */
    public function evaluationPeriod()
    {
        return $this->belongsTo(EvaluationPeriod::class, 'period_id', 'period_id');
    }

    public function sectionCourses()
    {
        return $this->hasMany(CourseSection::class, 'section_id'); // Adjust the foreign key as needed
    }

    // section_code
    public function getSectionCodeAttribute()
    {
        return $this->program->abbreviation . $this->year_level . '0' . $this->section_number;
    }

}

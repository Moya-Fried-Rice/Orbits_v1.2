<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $primaryKey = 'section_id';

    protected $fillable = [
        'section_id',
        'year_level',
        'section_number',
        'program_id',
        'period_id',
    ];

    public function courseSections()
    {
        return $this->hasMany(CourseSection::class, 'section_id', 'section_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'program_id');
    }

    public function getSectionCodeAttribute()
    {
        return $this->program->abbreviation . $this->year_level . '0' . $this->section_number;
    }


















    
    // public function evaluationPeriod()
    // {
    //     return $this->belongsTo(EvaluationPeriod::class, 'period_id', 'period_id');
    // }
    

}

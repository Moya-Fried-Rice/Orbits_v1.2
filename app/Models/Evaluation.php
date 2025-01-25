<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evaluation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'evaluations';
    protected $primaryKey = 'evaluation_id';
    public $timestamps = true;

    protected $fillable = [
        'course_section_id', 
        'survey_id', 
        'period_id',
    ];

    // NOTE: NOT YET DONE
    public function courseSection()
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id', 'course_section_id');
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id', 'survey_id');
    }

    public function evaluationPeriod()
    {
        return $this->belongsTo(EvaluationPeriod::class, 'period_id', 'period_id');
    }
}


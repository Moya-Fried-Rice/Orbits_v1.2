<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    // Define the table name (optional if it follows Laravel's convention)
    protected $table = 'evaluations';

    // Define the primary key (optional if it follows Laravel's convention)
    protected $primaryKey = 'evaluation_id';

    // Disable timestamps if you're not using created_at and updated_at fields
    public $timestamps = true;

    // Define the fillable attributes (to prevent mass assignment issues)
    protected $fillable = [
        'course_section_id', 
        'survey_id', 
        'period_id',
    ];

    // Define the relationship with CourseSection model
    public function courseSection()
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id', 'course_section_id');
    }

    // Define the relationship with Survey model
    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id', 'survey_id');
    }

    // Define the relationship with EvaluationPeriod model
    public function evaluationPeriod()
    {
        return $this->belongsTo(EvaluationPeriod::class, 'period_id', 'period_id');
    }

    // You can add any custom methods or additional relationships here
}


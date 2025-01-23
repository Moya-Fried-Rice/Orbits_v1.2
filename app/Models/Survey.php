<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Define the table name (optional if it follows Laravel's convention)
    protected $table = 'surveys';

    // Define the primary key (optional if it follows Laravel's convention)
    protected $primaryKey = 'survey_id'; // Assuming survey_id is the primary key

    // Disable timestamps if you're not using created_at and updated_at fields
    public $timestamps = true;

    // Define the fillable attributes (to prevent mass assignment issues)
    protected $fillable = [
        'survey_name',
    ];

    // Define the relationships (if any)

    // Relationship with Question model (Survey can have many questions)
    public function question()
    {
        return $this->hasMany(Question::class, 'survey_id', 'survey_id');
    }

    // Relationship with Evaluation model (Survey can be used in many evaluations)
    public function evaluationsPeriod()
    {
        return $this->belongsToMany(EvaluationPeriod::class, 'survey_period', 'survey_id', 'period_id')
                    ->withTimestamps()
                    ->withPivot('deleted_at');
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, 'survey_roles', 'survey_id', 'role_id');
    }

    public function criteria()
    {
        return $this->belongsToMany(QuestionCriteria::class, 'survey_criteria', 'survey_id', 'criteria_id')
                    ->withTimestamps();
    }

    // public function surveyPeriods()
    // {
    //     return $this->hasMany(SurveyPeriod::class, 'survey_id', 'survey_id');
    // }
}

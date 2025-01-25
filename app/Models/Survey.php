<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'surveys';
    protected $primaryKey = 'survey_id';
    public $timestamps = true;

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

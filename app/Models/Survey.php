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

    public function surveyRole()
    {
        return $this->hasMany(SurveyRole::class, 'survey_id', 'survey_id');
    }
    
    public function surveyCriteria()
    {
        return $this->hasMany(SurveyCriteria::class, 'survey_id', 'survey_id');
    }

    public function getTotalQuestionsAttribute()
    {
        return $this->surveyCriteria->sum(fn($sc) => $sc->questionCriteria->questions->count() ?? 0);
    }
















    







    public function evaluationsPeriod()
    {
        return $this->belongsToMany(EvaluationPeriod::class, 'survey_period', 'survey_id', 'period_id')
                    ->withTimestamps()
                    ->withPivot('deleted_at');
    }

}

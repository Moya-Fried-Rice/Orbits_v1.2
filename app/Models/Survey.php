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

    public function surveyRoles()
    {
        return $this->hasMany(SurveyRole::class, 'survey_id', 'survey_id');
    }
    
    public function questionCriterias()
    {
        return $this->hasMany(QuestionCriteria::class, 'survey_id', 'survey_id');
    }

    public function getTotalQuestionsAttribute()
    {
        return $this->questionCriterias->sum(function ($sc) {
            return $sc->questions ? $sc->questions->count() : 0;
        });
    }
}

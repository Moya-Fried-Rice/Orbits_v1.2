<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyCriteria extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'survey_criteria';
    protected $primaryKey = 'survey_criteria_id';
    public $timestamps = true;

    protected $fillable = [
        'survey_id',
        'criteria_id',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id', 'survey_id');
    }

    public function questionCriteria()
    {
        return $this->belongsTo(QuestionCriteria::class, 'criteria_id', 'criteria_id');
    } 

}

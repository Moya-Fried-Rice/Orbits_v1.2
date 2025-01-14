<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SurveyPeriod extends Pivot
{
    use HasFactory, SoftDeletes;

    protected $table = 'survey_period';

    protected $fillable = [
        'survey_id',
        'period_id',
    ];

    // Define relationships if needed
    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    public function evaluationPeriod()
    {
        return $this->belongsTo(EvaluationPeriod::class, 'period_id');
    }
}


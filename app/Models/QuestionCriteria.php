<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionCriteria extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'question_criteria';
    protected $primaryKey = 'criteria_id';

    public $timestamps = true;

    protected $fillable = [
        'description',
        'survey_id',
    ];

    // NOTE: NOT YET DONE
    public function question()
    {
        return $this->hasMany(Question::class, 'criteria_id', 'criteria_id');
    }

    public function survey()
    {
        return $this->belongsToMany(Survey::class, 'survey_criteria', 'criteria_id', 'survey_id')
                    ->withTimestamps();
    }
}

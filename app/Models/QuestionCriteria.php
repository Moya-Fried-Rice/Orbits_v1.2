<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionCriteria extends Model
{
    use HasFactory;

    // Define the table name (optional if it follows Laravel's convention)
    protected $table = 'question_criteria';

    // Define the primary key (optional if it follows Laravel's convention)
    protected $primaryKey = 'criteria_id'; // Assuming criteria_id is the primary key

    // Disable timestamps if you're not using created_at and updated_at fields
    public $timestamps = true;

    // Define the fillable attributes (to prevent mass assignment issues)
    protected $fillable = [
        'description',
        'survey_id',
    ];

    // Define the relationships (if any)

    // Define the relationship with the Question model (QuestionCriteria has many Questions)
    public function questions()
    {
        return $this->hasMany(Question::class, 'criteria_id', 'criteria_id');
    }

    // Define the relationship with the Survey model (QuestionCriteria belongs to Survey)
    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id', 'survey_id');
    }
}

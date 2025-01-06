<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Define the table name (optional if it follows Laravel's convention)
    protected $table = 'questions';

    // Define the primary key (optional if it follows Laravel's convention)
    protected $primaryKey = 'question_id'; // Assuming question_id is the primary key

    // Disable timestamps if you're not using created_at and updated_at fields
    public $timestamps = true;

    // Define the fillable attributes (to prevent mass assignment issues)
    protected $fillable = [
        'question_text',
        'question_code',
        'criteria_id',
    ];

    // Define the relationships (if any)

    // Define the relationship with the QuestionCriteria model (Question belongs to QuestionCriteria)
    public function criteria()
    {
        return $this->belongsTo(QuestionCriteria::class, 'criteria_id', 'criteria_id');
    }
}

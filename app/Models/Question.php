<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'questions';
    protected $primaryKey = 'question_id';
    public $timestamps = true;

    protected $fillable = [
        'question_text',
        'criteria_id',
    ];

    public function questionCriteria()
    {
        return $this->belongsTo(QuestionCriteria::class, 'criteria_id', 'criteria_id');
    }

    public function getQuestionCodeAttribute()
    {
        if (!$this->questionCriteria) {
            return null; // Return null if no related criteria
        }
    
        $description = trim($this->questionCriteria->description);
        $words = explode(' ', $description);
        $words = array_filter($words); // Remove extra spaces
    
        if (count($words) == 1) {
            // If only one word, take the first two letters
            $firstLetter = strtoupper(substr($words[0], 0, 1));
            $secondLetter = strtoupper(substr($words[0], 1, 1));
        } else {
            // If multiple words, take the first letter of first and last word
            $firstLetter = strtoupper(substr($words[0], 0, 1));
            $secondLetter = strtoupper(substr(end($words), 0, 1)); // Last word
        }
    
        // Append the question_id for uniqueness
        $id = $this->question_id;
    
        return "{$firstLetter}{$secondLetter}{$id}";
    }    
}

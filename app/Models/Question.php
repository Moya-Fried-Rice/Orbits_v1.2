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
        'position'
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
        $position = $this->position;
    
        return "{$firstLetter}{$secondLetter}{$position}";
    }    

    protected static function boot()
    {
        parent::boot();

        // Automatically set position when a new question is created
        static::creating(function ($question) {
            // Check for the maximum position in the same criteria
            $maxPosition = Question::where('criteria_id', $question->criteria_id)->max('position');

            // Set the position of the new question to the next number
            $question->position = $maxPosition ? $maxPosition + 1 : 1;
        });

        // When a question is being deleted, set its position to 0
        static::deleting(function ($question) {
            // Set the deleted question's position to 0
            $question->update(['position' => 0]);
        });

        // When a question is deleted, readjust positions of other questions
        static::deleted(function ($question) {
            // Readjust the positions of other questions in the same criteria
            Question::where('criteria_id', $question->criteria_id)
                    ->where('position', '>', 0)
                    ->orderBy('position')
                    ->get()
                    ->each(function ($q, $index) {
                        // Update the position to eliminate gaps, starting from 1
                        $q->update(['position' => $index + 1]);
                    });
        });

        // When a question is being restored, set it to the last position
        static::restoring(function ($question) {
            // Find the maximum position of the non-deleted questions in the same criteria
            $maxPosition = Question::where('criteria_id', $question->criteria_id)
                                    ->whereNull('deleted_at') // Only consider non-deleted questions
                                    ->max('position');

            // Position the restored question at the last position (maxPosition + 1)
            $question->position = $maxPosition ? $maxPosition + 1 : 1;
        });

        // When a question is restored, readjust the positions of other questions
        static::restored(function ($question) {
            // Readjust the positions of other questions in the same criteria
            Question::where('criteria_id', $question->criteria_id)
                    ->where('position', '>', 0)
                    ->orderBy('position')
                    ->get()
                    ->each(function ($q, $index) {
                        // Update the position to eliminate gaps, starting from 1
                        $q->update(['position' => $index + 1]);
                    });
        });
    }
}

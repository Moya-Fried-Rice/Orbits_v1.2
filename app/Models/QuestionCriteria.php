<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class QuestionCriteria extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'question_criteria';
    protected $primaryKey = 'criteria_id';

    public $timestamps = true;

    protected $fillable = [
        'description',
        'survey_id',
        'position'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class, 'criteria_id', 'criteria_id');
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id', 'survey_id'); // Fixed typo here
    }

    protected static function boot()
    {
        parent::boot();
    
        // Add logging for debugging
        static::creating(function ($criteria) {
            // Log for debugging
            Log::info('Creating new QuestionCriteria record. Survey ID: ' . $criteria->survey_id);
    
            // Find the max position for the same survey_id, excluding soft-deleted records
            $maxPosition = QuestionCriteria::where('survey_id', $criteria->survey_id)
                                           ->whereNull('deleted_at')  // Exclude soft-deleted records
                                           ->max('position');
            
            Log::info('Max Position (excluding soft-deleted): ' . $maxPosition);
    
            // Set position to next increment or 1 if it's the first entry
            $criteria->position = $maxPosition ? $maxPosition + 1 : 1;
    
            // Log the final position being set
            Log::info('Assigned Position: ' . $criteria->position);
        });
    
        // Handle soft-deleted record restoration
        static::restoring(function ($criteria) {
            // Log when a soft-deleted record is being restored
            Log::info('Restoring QuestionCriteria record. ID: ' . $criteria->criteria_id);
    
            // Restore the position value if necessary (but it should stay the same as before soft delete)
            // You can add logic here if you need to adjust anything when restoring, but typically the position won't change.
        });
    }
}

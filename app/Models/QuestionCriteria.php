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
    
        // Automatically set position when a new criteria is created
        static::creating(function ($criteria) {
            // Find the max position for the same survey_id, excluding soft-deleted records
            $maxPosition = QuestionCriteria::where('survey_id', $criteria->survey_id)
                                           ->whereNull('deleted_at')  // Exclude soft-deleted records
                                           ->max('position');
    
            // Set position to next increment or 1 if it's the first entry
            $criteria->position = $maxPosition ? $maxPosition + 1 : 1;
        });
    
        // When a criteria is being deleted, set its position to 0
        static::deleting(function ($criteria) {
            // Set the deleted criteria's position to 0
            $criteria->update(['position' => 0]);
        });
    
        // When a criteria is deleted, readjust positions of other criteria
        static::deleted(function ($criteria) {
            // Readjust the positions of other criteria in the same survey
            QuestionCriteria::where('survey_id', $criteria->survey_id)
                            ->where('position', '>', 0)
                            ->orderBy('position')
                            ->get()
                            ->each(function ($c, $index) {
                                // Update the position to eliminate gaps, starting from 1
                                $c->update(['position' => $index + 1]);
                            });
        });
    
        // When a criteria is being restored, set it to the last position
        static::restoring(function ($criteria) {
            // Find the maximum position of the non-deleted criteria in the same survey
            $maxPosition = QuestionCriteria::where('survey_id', $criteria->survey_id)
                                           ->whereNull('deleted_at') // Only consider non-deleted criteria
                                           ->max('position');
    
            // Position the restored criteria at the last position (maxPosition + 1)
            $criteria->position = $maxPosition ? $maxPosition + 1 : 1;
        });
    
        // When a criteria is restored, readjust the positions of other criteria
        static::restored(function ($criteria) {
            // Readjust the positions of other criteria in the same survey
            QuestionCriteria::where('survey_id', $criteria->survey_id)
                            ->where('position', '>', 0)
                            ->orderBy('position')
                            ->get()
                            ->each(function ($c, $index) {
                                // Update the position to eliminate gaps, starting from 1
                                $c->update(['position' => $index + 1]);
                            });
        });
    }    
}

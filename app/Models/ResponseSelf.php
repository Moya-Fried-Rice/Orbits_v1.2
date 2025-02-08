<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponseSelf extends Model
{
    protected $table = 'response_selves';
    protected $primaryKey = 'response_id';

    public $timestamps = false;

    protected $fillable = [
        'self_evaluation_id',
        'question_id',
        'rating'
    ];

    public function selfEvaluation()
    {
        return $this->belongsTo(SelfEvaluation::class, 'self_evaluation_id', 'self_evaluation_id'); // Fixed typo here
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'question_id'); // Fixed typo here
    }
}

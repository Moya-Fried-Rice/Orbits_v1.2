<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $table = 'responses';
    protected $primaryKey = 'response_id';

    public $timestamps = false;

    protected $fillable = [
        'user_evaluation_id',
        'question_id',
        'rating'
    ];

    public function userEvaluation()
    {
        return $this->belongsTo(UserEvaluation::class, 'user_evaluation_id', 'user_evaluation_id'); // Fixed typo here
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id'); // Fixed typo here
    }
}

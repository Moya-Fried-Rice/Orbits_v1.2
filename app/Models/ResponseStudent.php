<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponseStudent extends Model
{
    protected $table = 'response_students';
    protected $primaryKey = 'response_id';

    public $timestamps = false;

    protected $fillable = [
        'student_evaluation_id',
        'question_id',
        'rating'
    ];

    public function studentEvaluation()
    {
        return $this->belongsTo(StudentEvaluation::class, 'student_evaluation_id', 'student_evaluation_id'); // Fixed typo here
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'question_id'); // Fixed typo here
    }
}

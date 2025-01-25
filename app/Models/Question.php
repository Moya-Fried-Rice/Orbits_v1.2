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
        'question_code',
        'criteria_id',
    ];

    public function criteria()
    {
        return $this->belongsTo(QuestionCriteria::class, 'criteria_id', 'criteria_id');
    }
}

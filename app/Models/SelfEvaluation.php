<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelfEvaluation extends Model
{
    protected $table = 'self_evaluations';
    protected $primaryKey = 'self_evaluation_id';
    public $timestamps = false;

    protected $fillable = [
        'faculty_id',
        'course_section_id',
        'comment',
        'survey_id',
        'is_completed',
        'evaluated_at'
    ];

    public function responseSelves()
    {
        return $this->hasMany(ResponseSelf::class, 'self_evaluation_id', 'self_evaluation_id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public function courseSection()
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }
}

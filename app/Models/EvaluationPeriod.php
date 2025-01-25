<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvaluationPeriod extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'evaluation_periods';
    protected $primaryKey = 'period_id';
    public $timestamps = true;

    protected $fillable = [
        'semester',
        'academic_year',
        'start_date',
        'end_date',
        'status',
        'student_scoring',
        'self_scoring',
        'peer_scoring',
        'chair_scoring',
        'disseminated',
        'is_completed',
    ];

    // NOTE: NOT YET DONE
    public function evaluation()
    {
        return $this->hasMany(Evaluation::class, 'period_id', 'period_id');
    }

    public function survey()
    {
        return $this->belongsToMany(Survey::class, 'survey_period', 'period_id', 'survey_id')
                    ->withTimestamps()
                    ->withPivot('deleted_at');
    }
}

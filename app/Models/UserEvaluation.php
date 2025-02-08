<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEvaluation extends Model
{
    protected $table = 'user_evaluations';
    protected $primaryKey = 'user_evaluation_id';

    public $timestamps = false;

    protected $fillable = [
        'evaluation_id',
        'user_id',
        'comment',
        'is_completed',
        'evaluated_at'
    ];

    public function responses()
    {
        return $this->hasMany(Response::class, 'user_evaluation_id', 'user_evaluation_id'); // Fixed typo here
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class, 'evaluation_id'); // Fixed typo here
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Fixed typo here
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationPeriod extends Model
{
    use HasFactory;

    // Define the table name (optional if it follows Laravel's convention)
    protected $table = 'evaluation_periods';

    // Define the primary key (optional if it follows Laravel's convention)
    protected $primaryKey = 'period_id';

    // Disable timestamps if you're not using created_at and updated_at fields
    public $timestamps = true;

    // Define the fillable attributes (to prevent mass assignment issues)
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

    // Define the relationships (if any)

    // Define the one-to-many relationship with the Evaluation model
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'period_id', 'period_id');
    }

    // You can add any custom methods or additional relationships here
}

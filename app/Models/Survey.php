<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Define the table name (optional if it follows Laravel's convention)
    protected $table = 'surveys';

    // Define the primary key (optional if it follows Laravel's convention)
    protected $primaryKey = 'survey_id'; // Assuming survey_id is the primary key

    // Disable timestamps if you're not using created_at and updated_at fields
    public $timestamps = true;

    // Define the fillable attributes (to prevent mass assignment issues)
    protected $fillable = [
        'survey_name',
        'target_role', // Can be 'student', 'peer', 'self', or 'chair'
    ];

    // Define the relationships (if any)

    // Relationship with Question model (Survey can have many questions)
    public function questions()
    {
        return $this->hasMany(Question::class, 'survey_id', 'survey_id');
    }

    // Relationship with Evaluation model (Survey can be used in many evaluations)
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'survey_id', 'survey_id');
    }
}

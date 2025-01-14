<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyRole extends Model
{
    use HasFactory;

    // Define the table name (if it doesn't follow Laravel's pluralization convention)
    protected $table = 'survey_roles';  // Replace with the actual table name if different

    // Define the fillable attributes (optional)
    protected $fillable = ['survey_id', 'role_id']; 

    public function survey()
    {
        return $this->hasMany(Suvey::class);
    }

    public function role()
    {
        return $this->hasMany(Role::class);
    }
}

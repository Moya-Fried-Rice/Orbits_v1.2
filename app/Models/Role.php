<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $primaryKey = 'role_id';
    // Define the fillable attributes (optional, depending on your use case)
    protected $fillable = ['role_name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function surveyRole()
    {
        return $this->hasMany(SurveyRole::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}

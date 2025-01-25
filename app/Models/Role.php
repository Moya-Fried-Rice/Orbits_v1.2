<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'role_id';

    protected $fillable = ['role_name'];

    public function survey()
    {
        return $this->belongsToMany(Survey::class, 'survey_roles', 'survey_id', 'role_id');
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}

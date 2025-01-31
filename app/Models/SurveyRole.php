<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyRole extends Model
{
    protected $table = 'survey_roles';
    protected $primaryKey = 'survey_role_id';
    public $timestamps = true;

    protected $fillable = [
        'survey_id',
        'role_id',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id', 'survey_id');
    }
}

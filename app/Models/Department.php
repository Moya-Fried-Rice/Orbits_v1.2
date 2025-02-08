<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'departments';
    protected $primaryKey = 'department_id';
    public $timestamps = true;

    protected $fillable = [
        'department_name',
        'department_description',
        'department_code',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class, 'department_id', 'department_id');
    }

    public function faculties()
    {
        return $this->hasMany(Faculty::class, 'department_id', 'department_id');
    }

    public function programs()
    {
        return $this->hasMany(Program::class, 'department_id', 'department_id');
    }

    public function programChair()
    {
        return $this->hasOne(ProgramChair::class, 'department_id', 'department_id');
    }

    // FOR TRACKING
    // public function getTotalEvaluatedAttribute()
    // {
    //     return $this->courses->sum('total_evaluated');
    // }  
}

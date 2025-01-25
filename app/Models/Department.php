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

    public function course()
    {
        return $this->hasMany(Course::class, 'department_id', 'department_id');
    }

    public function faculty()
    {
        return $this->hasMany(Faculty::class, 'department_id', 'department_id');
    }

    public function program()
    {
        return $this->hasMany(Program::class, 'department_id', 'department_id');
    }

    public function programChair()
    {
        return $this->hasOne(ProgramChair::class, 'department_id', 'department_id');
    }
}

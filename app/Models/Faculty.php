<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faculty extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'faculties';
    protected $primaryKey = 'faculty_id';
    public $timestamps = true;

    protected $fillable = [
        'first_name',
        'last_name',
        'department_id',
        'phone_number',
        'profile_image',
    ];

    public function getFacultyNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function facultyCourse()
    {
        return $this->hasMany(FacultyCourse::class, 'faculty_id', 'faculty_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}

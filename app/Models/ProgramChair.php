<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramChair extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'program_chairs';
    protected $primaryKey = 'chair_id';
    public $timestamps = true;

    protected $fillable = [
        'first_name',
        'last_name',
        'department_id',
        'profile_image',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

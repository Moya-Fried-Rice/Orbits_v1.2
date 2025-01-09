<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function faculty()
    {
        return $this->hasOne(Faculty::class, 'user_id', 'id');
    }

    // A user can be linked to a student
    public function student()
    {
        return $this->hasOne(Student::class, 'user_id', 'id');
    }

    // A user can be linked to a program chair
    public function programChair()
    {
        return $this->hasOne(ProgramChair::class, 'user_id', 'id');
    }

    // A user can be linked to an admin
    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id', 'id');
    }
}

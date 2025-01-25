<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admins';
    protected $primaryKey = 'admin_id';
    public $timestamps = true;

    protected $fillable = [
        'username',
        'password',
        'email',
        'first_name',
        'last_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'admin_id');
    }
    
}

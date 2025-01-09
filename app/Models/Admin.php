<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    // Define the table name (optional if it follows Laravel's convention)
    protected $table = 'admins';

    // Define the primary key (optional if it follows Laravel's convention)
    protected $primaryKey = 'admin_id';

    // Enable timestamps (default behavior)
    public $timestamps = true;

    // Define the fillable attributes (to prevent mass assignment issues)
    protected $fillable = [
        'username',
        'password',
        'email',
        'first_name',
        'last_name',
    ];

    // Hide sensitive attributes from serialization
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Get the attributes that should be cast
    protected function casts(): array
    {
        return [
            'password' => 'hashed', // Ensure password is always hashed
        ];
    }

    // Custom logic for setting the password
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value); // Automatically hash password before saving
    }
}

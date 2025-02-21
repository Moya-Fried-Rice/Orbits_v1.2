<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    public function run()
    {
        // Step 1: Create a User record
        $user = User::create([
            'first_name' => 'Apple',
            'last_name' => 'Tree',
            'email' => 'appleadmin@gmail.com',
            'password' => Hash::make('admin123'), // Securely hashed password
            'phone_number' => null, // Optional, can be updated later
            'role_id' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Step 2: Create an Admin record and link it to the User
        Admin::create([
            'user_id' => $user->user_id, // Use `id` instead of `user_id`
        ]);
    }
}


<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminsTableSeeder extends Seeder
{
    public function run()
    {
        // Step 1: Create a User record
        $user = User::create([
            'name' => 'Apple Admin',
            'password' => Hash::make('admin123'), // Securely hashed password
            'email' => 'appleadmin@gmail.com',
            'created_at' => now(),  // Use `now()` instead of hardcoding the date
            'updated_at' => now(),
            'role_id' => 4,
        ]);

        // Step 2: Create an Admin record and link it to the User
        Admin::create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $user->user_id, // Ensure correct user_id is used (auto-incremented)
            'first_name' => 'Apple',
            'last_name' => 'Tree',
            'phone' => null, // Optional, can be updated later
            'email_verified_at' => now(), // Set email_verified_at to current timestamp if required
        ]);
    }
}

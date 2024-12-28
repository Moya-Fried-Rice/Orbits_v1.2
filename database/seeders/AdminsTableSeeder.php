<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    public function run()
    {
        // Inserting data into the admins table using Eloquent
        Admin::create([
            'admin_id' => 1,
            'username' => 'appleAdmin',
            'password' => Hash::make('password1'), // Replace with actual hash if needed
            'email' => 'admin1@example.com',
            'created_at' => '2024-10-13 06:52:28',
            'first_name' => 'Apple',
            'last_name' => 'Tree',
            'updated_at' => '2024-12-02 11:21:09',
        ]);

        Admin::create([
            'admin_id' => 2,
            'username' => 'admin2',
            'password' => Hash::make('password2'),
            'email' => 'admin2@example.com',
            'created_at' => '2024-10-13 06:52:28',
            'first_name' => 'Jesus',
            'last_name' => 'Christ',
            'updated_at' => '2024-12-02 11:21:09',
        ]);

        Admin::create([
            'admin_id' => 3,
            'username' => 'admin3',
            'password' => Hash::make('password3'),
            'email' => 'admmin@gmail.com',
            'created_at' => '2024-10-20 08:18:25',
            'first_name' => 'Banana',
            'last_name' => 'Monke',
            'updated_at' => '2024-12-02 11:21:09',
        ]);

        Admin::create([
            'admin_id' => 4,
            'username' => 'admin4',
            'password' => Hash::make('12345'),
            'email' => 'admin4@example.com',
            'created_at' => '2024-10-20 14:06:35',
            'first_name' => 'Glee',
            'last_name' => 'Moya',
            'updated_at' => '2024-12-02 11:21:09',
        ]);

        Admin::create([
            'admin_id' => 5,
            'username' => 'admin5',
            'password' => Hash::make('12345'),
            'email' => 'admin5@example.com',
            'created_at' => '2024-10-20 14:06:35',
            'first_name' => 'Sisha',
            'last_name' => 'Rojo',
            'updated_at' => '2024-12-02 11:21:09',
        ]);
    }
}

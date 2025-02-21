<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ProgramChairsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {  // Adjust the range as needed
            // Step 1: Generate first name and last name
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;

            // Step 2: Create a User record
            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('chair123'),  // Securely hashed password
                'phone_number' => $faker->phoneNumber,
                'role_id' => 3, // Program Chair role
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Step 3: Create a Program Chair record and link it to the User
            DB::table('program_chairs')->insert([
                [
                    'user_id' => $user->user_id, // Link to the created user
                    'department_id' => $index <= 7 ? $index : null,  // Assign department IDs if within range
                ]
            ]);            
        }
    }
}


<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;

class FacultiesTableSeeder extends Seeder
{
    public function run()
    {
        // Create an instance of Faker
        $faker = Faker::create();

        // Insert 10 sample faculty records
        foreach (range(1, 10) as $index) {
            // Step 1: Create a User record with combined first and last name
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            
            $user = User::create([
                'name' => $firstName . ' ' . $lastName, // Combine first and last name
                'password' => bcrypt('faculty123'),  // Default password or generate one
                'email' => $faker->unique()->safeEmail,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'role_id' => 2,
            ]);

            // Step 2: Create a Faculty record and link it to the User
            DB::table('faculties')->insert([
                'uuid' => (string) Str::uuid(),
                'faculty_id' => $index, // Auto-increment primary key for faculties
                'user_id' => $user->user_id, // Link to the created user's user_id
                'first_name' => $firstName, // Store the first name
                'last_name' => $lastName,   // Store the last name
                'department_id' => rand(1, 7),  // Assuming you have 7 departments
                'phone_number' => $faker->phoneNumber,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;

class ProgramChairsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {  // Adjust the range as needed
            // Step 1: Create a User record with combined first and last name
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;

            $user = User::create([
                'name' => $firstName . ' ' . $lastName, // Combine first and last name
                'password' => bcrypt('chair123'),  // Default password or generate one
                'email' => $faker->unique()->safeEmail,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'role_id' => 3,
            ]);

            // Step 2: Create a Program Chair record and link it to the User
            DB::table('program_chairs')->insert([
                [
                    'uuid' => (string) Str::uuid(),
                    'chair_id' => $index, // Auto-increment primary key for program_chairs
                    'user_id' => $user->user_id, // Link to the created user's user_id
                    'first_name' => $firstName, // Store the first name
                    'last_name' => $lastName,   // Store the last name
                    // Assign a unique department_id if a department exists, otherwise null
                    'department_id' => $index <= 7 ? $index : null,  // For demo, assuming the first 7 rows get department IDs
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            ]);            
        }
    }
}

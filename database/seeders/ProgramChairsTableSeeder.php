<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Models\User;

class ProgramChairsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {  // Adjust the range as needed
            // Step 1: Create a User record
            $user = User::create([
                'password' => bcrypt('password'),  // Default password or generate one
                'email' => $faker->unique()->safeEmail,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'role' => 'program_chair',
            ]);

            // Step 2: Create a Program Chair record and link it to the User
            DB::table('program_chairs')->insert([
                'chair_id' => $index, // Auto-increment primary key for program_chairs
                'user_id' => $user->id, // Link to the created user's user_id
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'department_id' => rand(1, 7),  // Assuming you have 7 departments
                'profile_image' => $faker->imageUrl(200, 200, 'people'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}

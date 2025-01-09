<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create(); // Create an instance of Faker

        // Insert fake data into the 'students' table
        foreach (range(1, 50) as $index) {  // Adjust the range based on how many students you want to generate
            // Step 1: Generate first name and last name
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;

            // Step 2: Create a User record for each student
            $user = User::create([
                'name' => $firstName . ' ' . $lastName,  // Combine first and last name for the name field
                'password' => bcrypt('password123'),  // Default password or generate one
                'email' => $faker->unique()->safeEmail,  // Unique email
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'role' => 'student',
            ]);

            // Step 3: Create a Student record and link it to the User
            DB::table('students')->insert([
                'student_id' => $index,  // Auto-increment primary key
                'user_id' => $user->user_id,  // Link the student to the created user
                'first_name' => $firstName,  // Store first name separately
                'last_name' => $lastName,  // Store last name separately
                'program_id' => $faker->numberBetween(1, 10),  // Random program ID (adjust range as needed)
                'phone_number' => $faker->phoneNumber,  // Random phone number
                'profile_image' => $faker->imageUrl(400, 400, 'people'),  // Random profile image URL
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}

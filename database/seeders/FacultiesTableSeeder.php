<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Faculty;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class FacultiesTableSeeder extends Seeder
{
    public function run()
    {
        // Create an instance of Faker
        $faker = Faker::create();

        // Step 1: Fetch all available course section IDs
        $courseSectionIds = DB::table('course_sections')->pluck('course_section_id')->toArray();

        // Shuffle course section IDs to randomize assignments
        shuffle($courseSectionIds);

        // Step 2: Insert 10 sample faculty records
        foreach (range(1, 10) as $index) {
            // Generate first name and last name
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;

            // Create a User record
            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('faculty123'), // Securely hashed password
                'phone_number' => $faker->phoneNumber,
                'role_id' => 2, // Faculty role
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create a Faculty record linked to the User
            $facultyId = DB::table('faculties')->insertGetId([
                'user_id' => $user->user_id, // Link to the created user
                'department_id' => rand(1, 7), // Assuming you have 7 departments
            ]);

            // Step 3: Assign one course section to this faculty
            if (!empty($courseSectionIds)) {
                $courseSectionId = array_pop($courseSectionIds); // Take one course section ID
                DB::table('faculty_courses')->insert([
                    'faculty_id' => $facultyId, // Link to the created faculty
                    'course_section_id' => $courseSectionId, // Link to the course section
                ]);
            }
        }
    }
}


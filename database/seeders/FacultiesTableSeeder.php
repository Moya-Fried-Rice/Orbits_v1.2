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

        // Step 1: Fetch all available course section IDs
        $courseSectionIds = DB::table('course_sections')->pluck('course_section_id')->toArray();

        // Shuffle course section IDs to randomize assignments
        shuffle($courseSectionIds);

        // Step 2: Insert 10 sample faculty records
        foreach (range(1, 10) as $index) {
            // Create a User record with combined first and last name
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;

            $user = User::create([
                'name' => $firstName . ' ' . $lastName, // Combine first and last name
                'password' => bcrypt('faculty123'), // Default password
                'email' => $faker->unique()->safeEmail,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'role_id' => 2,
            ]);

            // Create a Faculty record linked to the User
            $facultyId = DB::table('faculties')->insertGetId([
                'faculty_id' => $index, // Auto-increment primary key for faculties
                'user_id' => $user->user_id, // Link to the created user's user_id
                'first_name' => $firstName,
                'last_name' => $lastName,
                'department_id' => rand(1, 7), // Assuming you have 7 departments
                'phone_number' => $faker->phoneNumber,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Step 3: Assign one course section to this faculty
            if (!empty($courseSectionIds)) {
                $courseSectionId = array_pop($courseSectionIds); // Take one course section ID
                DB::table('faculty_courses')->insert([
                    'faculty_id' => $facultyId, // Link to the created faculty
                    'course_section_id' => $courseSectionId, // Link to the course section
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}

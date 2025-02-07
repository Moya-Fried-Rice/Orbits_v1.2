<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;

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

        // Step 1: Generate sample course section IDs (adjust to match your database)
        $courseSectionIds = DB::table('course_sections')->pluck('course_section_id')->toArray();
        
        // Create a specific student with the given credentials
        $specificUser = User::create([
            'name' => 'Cj Rojo',  // You can adjust the name as needed
            'password' => bcrypt('cjvhert2004'),
            'email' => '2023-2-03361@lpunetwork',
            'role_id' => 1,
        ]);

        // Create a Student record linked to this user
        $specificStudentId = DB::table('students')->insertGetId([
            'user_id' => $specificUser->user_id,
            'first_name' => 'Cj', 
            'last_name' => 'Rojo',
            'program_id' => $faker->numberBetween(1, 10),
            'phone_number' => $faker->phoneNumber,
        ]);

        // Assign 8 random course sections to this student
        $specificAssignedCourses = $faker->randomElements($courseSectionIds, 8);
        foreach ($specificAssignedCourses as $courseSectionId) {
            DB::table('student_courses')->insert([
                'student_id' => $specificStudentId,
                'course_section_id' => $courseSectionId,
            ]);
        }

        // Insert fake data into the 'students' table
        foreach (range(2, 200) as $index) {  // Adjust the range based on how many students you want to generate
            // Generate first name and last name
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;

            // Step 2: Create a User record for each student
            $user = User::create([
                'name' => $firstName . ' ' . $lastName,  // Combine first and last name for the name field
                'password' => bcrypt('student123'),  // Default password or generate one
                'email' => $faker->unique()->safeEmail,  // Unique email
                'role_id' => 1,
            ]);

            // Step 3: Create a Student record and link it to the User
            $studentId = DB::table('students')->insertGetId([
                'student_id' => $index,  // Auto-increment primary key
                'user_id' => $user->user_id,  // Link the student to the created user
                'first_name' => $firstName,  // Store first name separately
                'last_name' => $lastName,  // Store last name separately
                'program_id' => $faker->numberBetween(1, 10),  // Random program ID (adjust range as needed)
                'phone_number' => $faker->phoneNumber,  // Random phone number
            ]);

            // Step 4: Assign 8 random course sections to the student
            $assignedCourseSections = $faker->randomElements($courseSectionIds, 8); // Select 8 random course sections
            foreach ($assignedCourseSections as $courseSectionId) {
                DB::table('student_courses')->insert([
                    'student_id' => $studentId,  // Link to the created student
                    'course_section_id' => $courseSectionId,  // Link to a course section
                ]);
            }
        }

    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

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
            'first_name' => 'Cj',  
            'last_name' => 'Rojo',
            'email' => '2023-2-03361@lpunetwork.edu.ph',
            'password' => bcrypt('cjvhert2004'),
            'role_id' => 1,
            'phone_number' => '09123456789', // Example phone number
        ]);

        // Create a Student record linked to this user
        $specificStudentId = DB::table('students')->insertGetId([
            'user_id' => $specificUser->user_id, // Use `id` instead of `user_id`
            'program_id' => $faker->numberBetween(1, 10),
        ]);

        // Assign 8 random course sections to this student
        // $specificAssignedCourses = $faker->randomElements($courseSectionIds, 8);
        // foreach ($specificAssignedCourses as $courseSectionId) {
        //     DB::table('student_courses')->insert([
        //         'student_id' => $specificStudentId,
        //         'course_section_id' => $courseSectionId,
        //     ]);
        // }

        // Insert fake data into the 'students' table
        foreach (range(2, 200) as $index) {  // Adjust the range based on how many students you want to generate
            // Generate first name and last name
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;

            // Step 2: Create a User record for each student
            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $faker->unique()->safeEmail,  
                'password' => bcrypt('student123'),
                'role_id' => 1,
                'phone_number' => $faker->phoneNumber,
            ]);

            // Step 3: Create a Student record and link it to the User
            $studentId = DB::table('students')->insertGetId([
                'user_id' => $user->user_id,  // Link the student to the created user
                'program_id' => $faker->numberBetween(1, 10),  
            ]);

            // Step 4: Assign 8 random course sections to the student
            // $assignedCourseSections = $faker->randomElements($courseSectionIds, 8);
            // foreach ($assignedCourseSections as $courseSectionId) {
            //     DB::table('student_courses')->insert([
            //         'student_id' => $studentId,
            //         'course_section_id' => $courseSectionId,
            //     ]);
            // }
        }
    }
}

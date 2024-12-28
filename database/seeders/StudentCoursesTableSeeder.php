<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class StudentCoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create(); // Create an instance of Faker

        // Randomly assign students to course sections
        foreach (range(1, 100) as $index) {  // Adjust the range based on how many assignments you want
            DB::table('student_courses')->insert([
                'student_id' => $faker->numberBetween(1, 50),  // Random student ID from 1 to 50
                'course_section_id' => $faker->numberBetween(1, 53),  // Random course section ID from 1 to 53
            ]);
        }
    }
}

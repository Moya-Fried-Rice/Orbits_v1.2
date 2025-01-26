<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramCoursesTableSeeder extends Seeder
{
    public function run()
    {
        $programCourses = [
            // Program 20
            [20, 1], [20, 2], [20, 3], [20, 4], [20, 5], [20, 6], [20, 7], [20, 8],
            [20, 9], [20, 10], [20, 11], [20, 12], [20, 13], [20, 14], [20, 15], [20, 16],
            [20, 17], [20, 18], [20, 24], [20, 25], [20, 26], [20, 27], [20, 28], [20, 29],
            [20, 30], [20, 31],

            // Program 31
            [31, 3], [31, 4], [31, 7], [31, 8], [31, 9], [31, 19], [31, 20], [31, 21],
            [31, 22], [31, 23]
        ];

        // Insert all program_course pairs into the database with timestamps
        foreach ($programCourses as $programCourse) {
            DB::table('program_courses')->insert([
                'program_id' => $programCourse[0],
                'course_id' => $programCourse[1],
            ]);
        }
    }
}

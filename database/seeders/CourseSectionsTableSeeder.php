<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CourseSectionsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('course_sections')->insert([
            ['course_section_id' => 1, 'course_id' => 18, 'section' => 'CS101', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 2, 'course_id' => 17, 'section' => 'CS101', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 3, 'course_id' => 16, 'section' => 'CS101', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 4, 'course_id' => 15, 'section' => 'CS101', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 5, 'course_id' => 14, 'section' => 'CS101', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 6, 'course_id' => 13, 'section' => 'CS101', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 7, 'course_id' => 12, 'section' => 'CS101', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 8, 'course_id' => 11, 'section' => 'CS101', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 9, 'course_id' => 10, 'section' => 'CS101', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 10, 'course_id' => 18, 'section' => 'CS102', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 11, 'course_id' => 17, 'section' => 'CS102', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 12, 'course_id' => 16, 'section' => 'CS102', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 13, 'course_id' => 15, 'section' => 'CS102', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 14, 'course_id' => 14, 'section' => 'CS102', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 15, 'course_id' => 13, 'section' => 'CS102', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 16, 'course_id' => 12, 'section' => 'CS102', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 17, 'course_id' => 11, 'section' => 'CS102', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 18, 'course_id' => 10, 'section' => 'CS102', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 19, 'course_id' => 19, 'section' => 'MMA101', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 20, 'course_id' => 23, 'section' => 'MMA101', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 21, 'course_id' => 22, 'section' => 'MMA101', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 22, 'course_id' => 20, 'section' => 'MMA101', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 23, 'course_id' => 21, 'section' => 'MMA101', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 24, 'course_id' => 3, 'section' => 'MMA101', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 25, 'course_id' => 8, 'section' => 'MMA101', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 26, 'course_id' => 7, 'section' => 'MMA101', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 27, 'course_id' => 4, 'section' => 'MMA101', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 28, 'course_id' => 23, 'section' => 'MMA102', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 29, 'course_id' => 22, 'section' => 'MMA102', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 30, 'course_id' => 21, 'section' => 'MMA102', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 31, 'course_id' => 19, 'section' => 'MMA102', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 32, 'course_id' => 7, 'section' => 'MMA102', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 33, 'course_id' => 3, 'section' => 'MMA102', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 34, 'course_id' => 20, 'section' => 'MMA102', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 35, 'course_id' => 4, 'section' => 'MMA102', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 36, 'course_id' => 8, 'section' => 'MMA102', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 37, 'course_id' => 19, 'section' => 'MMA103', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 38, 'course_id' => 23, 'section' => 'MMA103', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 39, 'course_id' => 3, 'section' => 'MMA103', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 40, 'course_id' => 20, 'section' => 'MMA103', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 41, 'course_id' => 21, 'section' => 'MMA103', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 42, 'course_id' => 8, 'section' => 'MMA103', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 43, 'course_id' => 7, 'section' => 'MMA103', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 44, 'course_id' => 22, 'section' => 'MMA103', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 45, 'course_id' => 4, 'section' => 'MMA103', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 46, 'course_id' => 24, 'section' => 'CS201', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 47, 'course_id' => 25, 'section' => 'CS201', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 48, 'course_id' => 26, 'section' => 'CS201', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 49, 'course_id' => 27, 'section' => 'CS201', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 50, 'course_id' => 28, 'section' => 'CS201', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 51, 'course_id' => 29, 'section' => 'CS201', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 52, 'course_id' => 30, 'section' => 'CS201', 'period_id' => 1, 'updated_at' => Carbon::now()],
            ['course_section_id' => 53, 'course_id' => 31, 'section' => 'CS201', 'period_id' => 1, 'updated_at' => Carbon::now()],
        ]);
    }
}

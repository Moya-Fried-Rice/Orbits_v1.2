<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FacultyCoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an array of unique course section IDs (from 1 to 53)
        $courseSectionIds = range(1, 53);
        
        // Shuffle the array to randomize the course section IDs
        shuffle($courseSectionIds);

        // Now loop through the range 1 to 20 to insert faculty_course pairs
        foreach (range(1, 20) as $index) {
            DB::table('faculty_courses')->insert([
                'faculty_id' => rand(1, 10),  // Randomly select a faculty from 1 to 10
                'course_section_id' => $courseSectionIds[$index - 1],  // Assign a unique course_section_id
            ]);
        }
    }
}

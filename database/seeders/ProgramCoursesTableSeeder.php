<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramCoursesTableSeeder extends Seeder
{
    public function run()
    {
        // Get all programs
        $programs = \App\Models\Program::all();
    
        foreach ($programs as $program) {
            // Get all courses that are not already associated with this program
            $availableCourses = \App\Models\Course::whereNotIn('course_id', function($query) use ($program) {
                $query->select('course_id')
                      ->from('program_courses')
                      ->where('program_id', $program->id);
            })->get();
    
            // Randomly pick 5 courses for each program
            $randomCourses = $availableCourses->random(5);
    
            foreach ($randomCourses as $course) {
                DB::table('program_courses')->insert([
                    'program_id' => $program->program_id,
                    'course_id' => $course->course_id,
                    'year_level' => rand(1, 4), // Random year level between 1 and 4
                    'semester' => rand(1, 2), // Random year level between 1 and 4
                ]);                
            }
        }
    }    
}

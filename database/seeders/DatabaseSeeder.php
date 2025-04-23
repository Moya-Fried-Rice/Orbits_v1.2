<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

DB::table('migrations')->truncate();

class DatabaseSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // public function run()
    // {
    //     // Add all your seeders here
    //     $this->call([
    //         RolesTableSeeder::class,
    //         AdminsTableSeeder::class,
    //         DepartmentsTableSeeder::class,
    //         CoursesTableSeeder::class,
    //         ProgramsTableSeeder::class,
    //         SectionsTableSeeder::class,
    //         CourseSectionsTableSeeder::class,
    //         FacultiesTableSeeder::class,
    //         ProgramChairsTableSeeder::class,
    //         ProgramCoursesTableSeeder::class,
    //         SurveysTableSeeder::class,
    //         SurveyRoleTableSeeder::class,
    //         QuestionCriteriaTableSeeder::class,
    //         QuestionsTableSeeder::class,
    //         StudentsTableSeeder::class,
    //     ]);
    // }

    public function run()
    {
        DB::statement('DROP TABLE IF EXISTS migrations');

        // Get the contents of your SQL file
        $path = database_path('orbits_v1_2.sql');
        $sql = File::get($path);
        
        // Execute the SQL commands
        DB::unprepared($sql);
    }
}

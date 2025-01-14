<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add all your seeders here
        $this->call([
            RolesTableSeeder::class,
            AdminsTableSeeder::class,
            DepartmentsTableSeeder::class,
            FacultiesTableSeeder::class,
            CoursesTableSeeder::class,
            EvaluationPeriodsTableSeeder::class,
            ProgramsTableSeeder::class,
            CourseSectionsTableSeeder::class,
            ProgramChairsTableSeeder::class,
            ProgramCoursesTableSeeder::class,
            SurveysTableSeeder::class,
            SurveyRoleTableSeeder::class,
            QuestionCriteriaTableSeeder::class,
            QuestionsTableSeeder::class,
            StudentsTableSeeder::class,
            StudentCoursesTableSeeder::class,
            SurveyCriteriaTableSeeder::class,
            SurveyPeriodTableSeeder::class,
        ]);
    }
}

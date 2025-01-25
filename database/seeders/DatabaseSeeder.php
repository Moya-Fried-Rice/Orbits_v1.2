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
            CoursesTableSeeder::class,
            EvaluationPeriodsTableSeeder::class,
            ProgramsTableSeeder::class,
            SectionsTableSeeder::class,
            CourseSectionsTableSeeder::class,
            FacultiesTableSeeder::class,
            ProgramChairsTableSeeder::class,
            ProgramCoursesTableSeeder::class,
            SurveysTableSeeder::class,
            SurveyRoleTableSeeder::class,
            QuestionCriteriaTableSeeder::class,
            QuestionsTableSeeder::class,
            StudentsTableSeeder::class,
            SurveyCriteriaTableSeeder::class,
            SurveyPeriodTableSeeder::class,
        ]);
    }
}

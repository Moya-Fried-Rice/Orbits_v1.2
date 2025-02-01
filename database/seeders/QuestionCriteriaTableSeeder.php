<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionCriteriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('question_criteria')->insert([
            ['criteria_id' => 1, 'description' => 'Teaching Competence', 'survey_id' => 1],
            ['criteria_id' => 2, 'description' => 'Classroom Management', 'survey_id' => 1],
            ['criteria_id' => 3, 'description' => 'Knowledge on the Subject Matter', 'survey_id' => 2],
            ['criteria_id' => 4, 'description' => 'Teaching Performance (Methods/Strategies, Classroom Management and Evaluation)', 'survey_id' => 2]
        ]);
    }
}

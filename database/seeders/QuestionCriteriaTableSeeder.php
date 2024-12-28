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
            ['criteria_id' => 3, 'description' => 'Knowledge on the Subject Matter', 'survey_id' => 3],
            ['criteria_id' => 4, 'description' => 'Teaching Performance (Methods/Strategies, Classroom Management and Evaluation)', 'survey_id' => 3],
            ['criteria_id' => 5, 'description' => 'Performance of Duties', 'survey_id' => 3],
            ['criteria_id' => 6, 'description' => 'Collaboration and Teamwork', 'survey_id' => 2],
            ['criteria_id' => 7, 'description' => 'Communication Skills', 'survey_id' => 2],
            ['criteria_id' => 8, 'description' => 'Self-Awareness', 'survey_id' => 4],
            ['criteria_id' => 9, 'description' => 'Goal Achievement', 'survey_id' => 4],
        ]);
    }
}

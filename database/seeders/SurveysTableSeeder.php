<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurveysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('surveys')->insert([
            ['survey_id' => 1, 'survey_name' => 'Student Evaluation', 'created_at' => '2024-10-13 06:56:45', 'target_role' => 'student'],
            ['survey_id' => 2, 'survey_name' => 'Faculty Evaluation', 'created_at' => '2024-10-13 06:56:45', 'target_role' => 'peer'],
            ['survey_id' => 3, 'survey_name' => 'Chair Feedback', 'created_at' => '2024-10-27 23:56:38', 'target_role' => 'chair'],
            ['survey_id' => 4, 'survey_name' => 'Self Evaluation', 'created_at' => '2024-11-01 18:10:16', 'target_role' => 'self'],
        ]);
    }
}

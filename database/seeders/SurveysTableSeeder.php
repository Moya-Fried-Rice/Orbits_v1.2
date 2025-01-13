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
            ['survey_id' => 1, 'survey_name' => 'Student Evaluation', 'created_at' => '2024-10-13 06:56:45'],
            ['survey_id' => 2, 'survey_name' => 'Faculty Evaluation', 'created_at' => '2024-10-13 06:56:45'],
        ]);
    }
}

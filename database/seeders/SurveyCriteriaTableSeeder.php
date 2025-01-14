<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurveyCriteriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('survey_criteria')->insert([
            ['criteria_id' => 1, 'survey_id' => 1],
            ['criteria_id' => 2, 'survey_id' => 1],
            ['criteria_id' => 3, 'survey_id' => 2],
            ['criteria_id' => 4, 'survey_id' => 2],
            ['criteria_id' => 5, 'survey_id' => 2],
            ['criteria_id' => 6, 'survey_id' => 2],
            ['criteria_id' => 7, 'survey_id' => 2],
            ['criteria_id' => 8, 'survey_id' => 2],
            ['criteria_id' => 9, 'survey_id' => 2],
        ]);
    }
}

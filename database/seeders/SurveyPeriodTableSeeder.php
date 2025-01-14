<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurveyPeriodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('survey_period')->insert([
            ['period_id' => 1, 'survey_id' => 1],
            ['period_id' => 1, 'survey_id' => 2],
        ]);
    }
}

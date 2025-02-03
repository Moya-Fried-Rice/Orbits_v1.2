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
            ['survey_id' => 1, 'survey_name' => 'Faculty Performance Evaluation'],
            ['survey_id' => 2, 'survey_name' => 'Deans/Program Chair/Coordinators/QC Head of Instructions Evaluation'],
        ]);
    }
}

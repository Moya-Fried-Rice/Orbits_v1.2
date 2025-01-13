<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SurveyRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Insert survey roles
        DB::table('survey_roles')->insert([
            ['survey_id' => 1, 'role' => 'student', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['survey_id' => 2, 'role' => 'faculty', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['survey_id' => 2, 'role' => 'peer', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['survey_id' => 2, 'role' => 'program_chair', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}

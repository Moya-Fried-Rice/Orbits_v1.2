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
            ['survey_id' => 1, 'role_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['survey_id' => 2, 'role_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['survey_id' => 2, 'role_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}

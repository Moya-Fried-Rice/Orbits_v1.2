<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EvaluationPeriodsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('evaluation_periods')->insert([
            [
                'period_id' => 1,
                'semester' => '1st',
                'academic_year' => '2024-2025',
                'start_date' => Carbon::parse('2024-11-19'),
                'end_date' => Carbon::parse('2024-12-20'),
                'status' => 'active',
                'student_scoring' => 50,
                'self_scoring' => 5,
                'peer_scoring' => 5,
                'chair_scoring' => 40,
                'disseminated' => 0,
                'is_completed' => 0,
            ],
        ]);
    }
}

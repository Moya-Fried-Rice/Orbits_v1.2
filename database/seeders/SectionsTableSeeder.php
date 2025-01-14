<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Section;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sections')->insert([
            ['section_id' => 1, 'program_id' => 20, 'year_level' => 1, 'section_number' => 1, 'period_id' => 1,],
            ['section_id' => 2, 'program_id' => 20, 'year_level' => 1, 'section_number' => 2, 'period_id' => 1,],
            ['section_id' => 3, 'program_id' => 31, 'year_level' => 1, 'section_number' => 1, 'period_id' => 1,],
            ['section_id' => 4, 'program_id' => 31, 'year_level' => 1, 'section_number' => 2, 'period_id' => 1,],
            ['section_id' => 5, 'program_id' => 31, 'year_level' => 1, 'section_number' => 3, 'period_id' => 1,],
            ['section_id' => 6, 'program_id' => 31, 'year_level' => 2, 'section_number' => 1, 'period_id' => 1,],
        ]);
    }
}

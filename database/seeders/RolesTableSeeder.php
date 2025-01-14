<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['role_name' => 'student'],
            ['role_name' => 'faculty'],
            ['role_name' => 'program_chair'],
            ['role_name' => 'admin'],
        ]);
    }
}

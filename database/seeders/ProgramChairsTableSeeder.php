<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class ProgramChairsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {  // Adjust the range as needed
            DB::table('program_chairs')->insert([
                'chair_id' => $index,
                'username' => $faker->userName,
                'password' => bcrypt('password'),  // You can set a default password or generate one
                'email' => $faker->unique()->safeEmail,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'department_id' => rand(1, 7),  // Assuming you have 7 departments
                'profile_image' => $faker->imageUrl(200, 200, 'people'),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FacultiesTableSeeder extends Seeder
{
    public function run()
    {
        // Create an instance of Faker
        $faker = Faker::create();

        // Insert 10 sample faculty records (You can adjust the number)
        foreach (range(1, 10) as $index) {
            DB::table('faculties')->insert([
                'faculty_id' => $index,
                'username' => $faker->userName,
                'password' => bcrypt('password'),  // You can set a default password or generate one
                'email' => $faker->unique()->safeEmail,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'department_id' => rand(1, 7),  // Assuming you have 7 departments
                'phone_number' => $faker->phoneNumber,
                'profile_image' => $faker->imageUrl(200, 200, 'people'),
            ]);
        }
    }
}

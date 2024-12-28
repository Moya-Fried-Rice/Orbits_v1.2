<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create(); // Create an instance of Faker

        // Insert fake data into the 'students' table
        foreach (range(1, 50) as $index) {  // Adjust the range based on how many students you want to generate
            DB::table('students')->insert([
                'student_id' => $index,  // If student_id is auto-increment, you can omit this
                'username' => $faker->unique()->userName,  // Unique username
                'password' => bcrypt('password123'),  // You can set a default password or generate a random one
                'email' => $faker->unique()->safeEmail,  // Unique email
                'created_at' => now(),  // Current timestamp for creation
                'updated_at' => now(),  // Current timestamp for update
                'first_name' => $faker->firstName,  // Random first name
                'last_name' => $faker->lastName,  // Random last name
                'program_id' => $faker->numberBetween(1, 10),  // Random program ID (adjust range as needed)
                'phone_number' => $faker->phoneNumber,  // Random phone number
                'profile_image' => $faker->imageUrl(400, 400, 'people')  // Random profile image URL
            ]);
        }
    }
}

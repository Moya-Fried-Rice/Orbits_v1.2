<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('departments')->insert([
            [
                'department_id' => 1,
                'department_name' => 'College of Engineering, Computer Studies and Architecture',
                'department_description' => 'Combining technical skills with creative design, this college prepares students for careers in engineering, IT, and architecture. It emphasizes innovation, problem-solving, and practical applications.',
                'department_code' => 'COECSA',
            ],
            [
                'department_id' => 2,
                'department_name' => 'College of Fine Arts and Design',
                'department_description' => 'This college nurtures artistic talent and creativity, offering programs in visual arts, graphic design, and multimedia. Students develop a solid foundation in artistic expression and technical skills.',
                'department_code' => 'CFAD',
            ],
            [
                'department_id' => 3,
                'department_name' => 'College of International Tourism and Hospitality Management',
                'department_description' => 'Focused on global hospitality and tourism, this college equips students with the skills to manage hotels, resorts, and travel services. Programs emphasize cultural sensitivity, customer service, and industry trends.',
                'department_code' => 'CITHM',
            ],
            [
                'department_id' => 4,
                'department_name' => 'College of Nursing',
                'department_description' => 'Dedicated to training compassionate and skilled nurses, this college emphasizes patient care, clinical skills, and ethical practice. Graduates are prepared to excel in various healthcare settings and provide high-quality nursing care.',
                'department_code' => 'CON',
            ],
            [
                'department_id' => 5,
                'department_name' => 'College of Allied Medical Sciences',
                'department_description' => 'The College of Allied Medical Sciences (CAMS) provides education and training in various healthcare fields, preparing students for careers in medical technology, physical therapy, nursing, and other allied health professions. It emphasizes hands-on learning and healthcare excellence.',
                'department_code' => 'CAMS',
            ],
            [
                'department_id' => 6,
                'department_name' => 'College of Liberal Arts and Education',
                'department_description' => 'Offers a diverse range of programs focused on critical thinking, creativity, and communication. It prepares students for careers in education, social sciences, humanities, and the arts, fostering a well-rounded, socially responsible approach to learning.',
                'department_code' => 'CLAE',
            ],
            [
                'department_id' => 7,
                'department_name' => 'College of Business Administration',
                'department_description' => 'Department dedicated to the design, construction, and operation of machinery and mechanical systems.The College of Business Administration (CBA) equips students with essential business skills in management, finance, and marketing, preparing them for leadership roles in the global business world.',
                'department_code' => 'CBA',
            ],
        ]);
    }
}

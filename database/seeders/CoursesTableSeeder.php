<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courses')->insert([
            [
                'course_id' => 1,
                'course_name' => 'Introduction to Computing',
                'created_at' => Carbon::parse('2024-12-02 12:22:29'),
                'course_description' => 'An introductory course to computing, covering basic computer systems and applications.',
                'course_code' => 'DCSN01C',
                'department_id' => 1,
                'updated_at' => Carbon::parse('2024-12-02 12:22:29')
            ],
            [
                'course_id' => 2,
                'course_name' => 'Computer Programming 1',
                'created_at' => Carbon::parse('2024-12-02 12:22:29'),
                'course_description' => 'This course introduces programming concepts and techniques in a structured programming environment.',
                'course_code' => 'DCSN02C',
                'department_id' => 1,
                'updated_at' => Carbon::parse('2024-12-02 12:22:29')
            ],
            [
                'course_id' => 3,
                'course_name' => 'Mathematics In the Modern World',
                'created_at' => Carbon::parse('2024-12-02 12:22:29'),
                'course_description' => 'Focus on mathematical principles that are used in everyday life and in various modern fields.',
                'course_code' => 'MATH01G',
                'department_id' => 5,
                'updated_at' => Carbon::parse('2024-12-02 12:24:18')
            ],
            [
                'course_id' => 4,
                'course_name' => 'Understanding the Self',
                'created_at' => Carbon::parse('2024-12-02 12:22:29'),
                'course_description' => 'A course designed to explore personal identity, self-awareness, and the human experience.',
                'course_code' => 'UTSN0IG',
                'department_id' => 3,
                'updated_at' => Carbon::parse('2024-12-02 12:24:24')
            ],
            [
                'course_id' => 5,
                'course_name' => 'Ethics',
                'created_at' => Carbon::parse('2024-12-02 12:22:29'),
                'course_description' => 'Introduction to the principles of ethics, moral philosophy, and contemporary ethical issues.',
                'course_code' => 'ESTN01G',
                'department_id' => 6,
                'updated_at' => Carbon::parse('2024-12-02 12:24:31')
            ],
            [
                'course_id' => 6,
                'course_name' => 'JPL Life and His Works',
                'created_at' => Carbon::parse('2024-12-02 12:22:29'),
                'course_description' => 'Study of the life and works of J.P. Lang, focusing on his contributions to science and literature.',
                'course_code' => 'JPLN01G',
                'department_id' => 5,
                'updated_at' => Carbon::parse('2024-12-02 12:24:37')
            ],
            [
                'course_id' => 7,
                'course_name' => 'Physical Activities Toward Health and Fitness 1',
                'created_at' => Carbon::parse('2024-12-02 12:22:29'),
                'course_description' => 'A physical education course designed to promote health and fitness through physical activities.',
                'course_code' => 'PATHFit1',
                'department_id' => 4,
                'updated_at' => Carbon::parse('2024-12-02 12:55:55')
            ],
            [
                'course_id' => 8,
                'course_name' => 'National Service Training Program 1',
                'created_at' => Carbon::parse('2024-12-02 12:22:29'),
                'course_description' => 'A course aimed at fostering civic consciousness and defense preparedness through community service and military training.',
                'course_code' => 'NSTPN01G',
                'department_id' => 7,
                'updated_at' => Carbon::parse('2024-12-02 12:50:40')
            ],
            [
                'course_id' => 9,
                'course_name' => 'Quality Consciousness, Processes and Habits',
                'created_at' => Carbon::parse('2024-12-02 12:22:29'),
                'course_description' => 'A course that explores quality assurance, process improvement, and establishing good work habits.',
                'course_code' => 'CPHN0IC',
                'department_id' => 7,
                'updated_at' => Carbon::parse('2024-12-02 12:55:47')
            ],
            [
                'course_id' => 10,
                'course_name' => 'Computer Programming 2',
                'created_at' => Carbon::parse('2024-12-02 12:23:36'),
                'course_description' => 'This course continues the study of programming with an emphasis on algorithms, data structures, and advanced programming concepts.',
                'course_code' => 'DCSN03C',
                'department_id' => 1,
                'updated_at' => Carbon::parse('2024-12-02 12:23:36')
            ],
            [
                'course_id' => 11,
                'course_name' => 'Discrete Structures 1',
                'created_at' => Carbon::parse('2024-12-02 12:23:36'),
                'course_description' => 'Introduction to discrete mathematical structures used in computer science, such as sets, graphs, and combinatorics.',
                'course_code' => 'CSCN01C',
                'department_id' => 1,
                'updated_at' => Carbon::parse('2024-12-02 12:23:36')
            ],
            [
                'course_id' => 12,
                'course_name' => 'Social Issues and Professional Practice',
                'created_at' => Carbon::parse('2024-12-02 12:23:36'),
                'course_description' => 'A course that explores the social, ethical, and legal issues related to the practice of computing and technology professions.',
                'course_code' => 'DCSN07C',
                'department_id' => 1,
                'updated_at' => Carbon::parse('2024-12-02 12:23:36')
            ],
            [
                'course_id' => 13,
                'course_name' => 'The Contemporary World',
                'created_at' => Carbon::parse('2024-12-02 12:23:36'),
                'course_description' => 'Study of global issues and how they affect modern society, politics, and economics.',
                'course_code' => 'TCWN01G',
                'department_id' => 5,
                'updated_at' => Carbon::parse('2024-12-02 12:25:41')
            ],
            [
                'course_id' => 14,
                'course_name' => 'Purposive Communication',
                'created_at' => Carbon::parse('2024-12-02 12:23:36'),
                'course_description' => 'Course focused on effective communication skills across various media, emphasizing purpose-driven communication in professional and personal contexts.',
                'course_code' => 'ENGL0IG',
                'department_id' => 3,
                'updated_at' => Carbon::parse('2024-12-02 12:25:34')
            ],
            [
                'course_id' => 15,
                'course_name' => 'Pre-Calculus and Functional Mathematics',
                'created_at' => Carbon::parse('2024-12-02 12:23:36'),
                'course_description' => 'A preparatory mathematics course that covers functions, algebra, and the basic concepts necessary for calculus.',
                'course_code' => 'MATN07G',
                'department_id' => 5,
                'updated_at' => Carbon::parse('2024-12-02 12:23:36')
            ],
            [
                'course_id' => 16,
                'course_name' => 'Living in the IT Era',
                'created_at' => Carbon::parse('2024-12-02 12:23:36'),
                'course_description' => 'Course that focuses on the role of information technology in everyday life and the workplace, including its impact on society and individuals.',
                'course_code' => 'LVTN01C',
                'department_id' => 1,
                'updated_at' => Carbon::parse('2024-12-02 12:23:36')
            ],
            [
                'course_id' => 17,
                'course_name' => 'Physical Activities Toward Health and Fitness 2',
                'created_at' => Carbon::parse('2024-12-02 12:23:36'),
                'course_description' => 'Continued physical education focusing on advanced activities aimed at improving fitness and health.',
                'course_code' => 'PATHFit2',
                'department_id' => 4,
                'updated_at' => Carbon::parse('2024-12-02 12:26:21')
            ],
            [
                'course_id' => 18,
                'course_name' => 'National Service Training Program 2',
                'created_at' => Carbon::parse('2024-12-02 12:23:36'),
                'course_description' => 'Continuation of the National Service Training Program (NSTP) that emphasizes civic duty and community involvement.',
                'course_code' => 'NSTPN02G',
                'department_id' => 7,
                'updated_at' => Carbon::parse('2024-12-02 12:26:08')
            ],
            [
                'course_id' => 19,
                'course_name' => 'Drawing 1: Basic Form and Shape',
                'created_at' => Carbon::parse('2024-12-02 12:53:07'),
                'course_description' => 'An introductory course focusing on the basic principles of drawing, with emphasis on form, shape, and basic techniques.',
                'course_code' => 'ARTN01G',
                'department_id' => 6,
                'updated_at' => Carbon::parse('2024-12-02 12:53:07')
            ],
            [
                'course_id' => 20,
                'course_name' => 'Introduction to Multimedia Arts',
                'created_at' => Carbon::parse('2024-12-02 12:53:07'),
                'course_description' => 'An introductory course on multimedia arts, exploring graphic design, animation, and video production techniques.',
                'course_code' => 'BMMA01F',
                'department_id' => 2,
                'updated_at' => Carbon::parse('2024-12-02 12:53:07')
            ],
            [
                'course_id' => 21,
                'course_name' => 'History of Graphic Design',
                'created_at' => Carbon::parse('2024-12-02 12:53:07'),
                'course_description' => 'A course covering the history and evolution of graphic design, from its origins to modern developments.',
                'course_code' => 'BMMA02F',
                'department_id' => 2,
                'updated_at' => Carbon::parse('2024-12-02 12:53:07')
            ],
            [
                'course_id' => 22,
                'course_name' => 'Science, Technology and Society',
                'created_at' => Carbon::parse('2024-12-02 12:53:07'),
                'course_description' => 'A course exploring the interaction between science, technology, and society, with a focus on their impact on modern life.',
                'course_code' => 'STSN11G',
                'department_id' => 5,
                'updated_at' => Carbon::parse('2024-12-02 12:53:07')
            ],
            [
                'course_id' => 23,
                'course_name' => 'Kontekstwalisadong Komunikasyon Sa Filipino',
                'created_at' => Carbon::parse('2024-12-02 12:53:07'),
                'course_description' => 'A Filipino course focusing on contextualized communication and the use of Filipino in various real-world settings.',
                'course_code' => 'FLIN01G',
                'department_id' => 2,
                'updated_at' => Carbon::parse('2024-12-02 12:57:46')
            ],
            [
                'course_id' => 24,
                'course_name' => 'Data Structures and Algorithms',
                'created_at' => Carbon::parse('2024-12-02 13:20:05'),
                'course_description' => 'A course that covers the essential concepts of data structures and algorithms, essential for efficient programming.',
                'course_code' => 'DCSN04C',
                'department_id' => 1,
                'updated_at' => Carbon::parse('2024-12-02 13:20:05')
            ],
            [
                'course_id' => 25,
                'course_name' => 'Object Oriented Programming',
                'created_at' => Carbon::parse('2024-12-02 13:20:05'),
                'course_description' => 'An introductory course to Object Oriented Programming (OOP), including classes, objects, inheritance, and polymorphism.',
                'course_code' => 'CSCN02C',
                'department_id' => 1,
                'updated_at' => Carbon::parse('2024-12-02 13:20:05')
            ],
            [
                'course_id' => 26,
                'course_name' => 'Discrete Structures 2',
                'created_at' => Carbon::parse('2024-12-02 13:20:05'),
                'course_description' => 'A continuation of Discrete Structures 1, focusing on more advanced topics in mathematics and logic for computer science.',
                'course_code' => 'CSCN03C',
                'department_id' => 1,
                'updated_at' => Carbon::parse('2024-12-02 13:20:05')
            ],
            [
                'course_id' => 27,
                'course_name' => 'CS Elective 1',
                'created_at' => Carbon::parse('2024-12-02 13:20:05'),
                'course_description' => 'A Computer Science elective course offering students an opportunity to dive into specialized topics of their interest in CS.',
                'course_code' => 'CSELCO1C',
                'department_id' => 1,
                'updated_at' => Carbon::parse('2024-12-02 13:20:05')
            ],
            [
                'course_id' => 28,
                'course_name' => 'Differential and Integral Calculus',
                'created_at' => Carbon::parse('2024-12-02 13:20:05'),
                'course_description' => 'A math course covering the fundamentals of differential and integral calculus, essential for many fields of engineering and computer science.',
                'course_code' => 'MATH23E',
                'department_id' => 5,
                'updated_at' => Carbon::parse('2024-12-02 13:20:05')
            ],
            [
                'course_id' => 29,
                'course_name' => 'Art Appreciation',
                'created_at' => Carbon::parse('2024-12-02 13:20:05'),
                'course_description' => 'A course that introduces students to the appreciation of visual arts and their cultural significance.',
                'course_code' => 'HUMNO2G',
                'department_id' => 5,
                'updated_at' => Carbon::parse('2024-12-02 13:20:05')
            ],
            [
                'course_id' => 30,
                'course_name' => 'Life and Works of Rizal',
                'created_at' => Carbon::parse('2024-12-02 13:20:05'),
                'course_description' => 'A course examining the life and works of Dr. Jose Rizal, the national hero of the Philippines.',
                'course_code' => 'LWRNDIG',
                'department_id' => 4,
                'updated_at' => Carbon::parse('2024-12-02 13:20:05')
            ],
            [
                'course_id' => 31,
                'course_name' => 'Physical Activities Toward Health and Fitness 3',
                'created_at' => Carbon::parse('2024-12-02 13:20:05'),
                'course_description' => 'A physical education course focused on advanced fitness activities to promote health and well-being.',
                'course_code' => 'PATHFit3',
                'department_id' => 4,
                'updated_at' => Carbon::parse('2024-12-02 13:23:33')
            ]
        ]);
    }
}

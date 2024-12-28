<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert([
            ['question_id' => 1, 'question_text' => 'States the objectives of the lesson/activities before the start of the class.', 'created_at' => Carbon::now(), 'question_code' => 'TC1', 'criteria_id' => 1],
            ['question_id' => 2, 'question_text' => 'Orients the students on the planned activities for the day.', 'created_at' => Carbon::now(), 'question_code' => 'TC2', 'criteria_id' => 1],
            ['question_id' => 3, 'question_text' => 'Adheres to school regulations on proper conduct/behavior.', 'created_at' => Carbon::now(), 'question_code' => 'TC3', 'criteria_id' => 1],
            ['question_id' => 4, 'question_text' => 'Creates/Modifies appropriate activities as necessary.', 'created_at' => Carbon::now(), 'question_code' => 'TC4', 'criteria_id' => 1],
            ['question_id' => 5, 'question_text' => 'Communicates ideas clearly and correctly.', 'created_at' => Carbon::now(), 'question_code' => 'TC5', 'criteria_id' => 1],
            ['question_id' => 6, 'question_text' => 'Demonstrates teaching/laboratory skills with ease.', 'created_at' => Carbon::now(), 'question_code' => 'TC6', 'criteria_id' => 1],
            ['question_id' => 7, 'question_text' => 'Uses teaching methods appropriate to the lesson/activity.', 'created_at' => Carbon::now(), 'question_code' => 'TC7', 'criteria_id' => 1],
            ['question_id' => 8, 'question_text' => 'Gives appropriate comments or relevant feedbacks.', 'created_at' => Carbon::now(), 'question_code' => 'TC8', 'criteria_id' => 1],
            ['question_id' => 9, 'question_text' => 'Provides opportunities for student participation.', 'created_at' => Carbon::now(), 'question_code' => 'TC9', 'criteria_id' => 1],
            ['question_id' => 10, 'question_text' => 'Presents lesson/activities at a pace appropriate to student capability.', 'created_at' => Carbon::now(), 'question_code' => 'TC10', 'criteria_id' => 1],
            ['question_id' => 11, 'question_text' => 'Provides examples that show application of concept.', 'created_at' => Carbon::now(), 'question_code' => 'TC11', 'criteria_id' => 1],
            ['question_id' => 12, 'question_text' => 'Relates lesson/activities to other fields of knowledge.', 'created_at' => Carbon::now(), 'question_code' => 'TC12', 'criteria_id' => 1],
            ['question_id' => 13, 'question_text' => 'Uses the medium of instruction as required by the course.', 'created_at' => Carbon::now(), 'question_code' => 'TC13', 'criteria_id' => 1],
            ['question_id' => 15, 'question_text' => 'Informs students of their class performance.', 'created_at' => Carbon::now(), 'question_code' => 'CM2', 'criteria_id' => 2],
            ['question_id' => 16, 'question_text' => 'Attends class regularly and punctually.', 'created_at' => Carbon::now(), 'question_code' => 'CM3', 'criteria_id' => 2],
            ['question_id' => 17, 'question_text' => 'Uses time efficiently and effectively.', 'created_at' => Carbon::now(), 'question_code' => 'CM4', 'criteria_id' => 2],
            ['question_id' => 18, 'question_text' => 'Checks attendance regularly.', 'created_at' => Carbon::now(), 'question_code' => 'CM5', 'criteria_id' => 2],
            ['question_id' => 19, 'question_text' => 'Follows schedule for examination.', 'created_at' => Carbon::now(), 'question_code' => 'CM6', 'criteria_id' => 2],
            ['question_id' => 20, 'question_text' => 'Creates an environment conducive for learning.', 'created_at' => Carbon::now(), 'question_code' => 'CM7', 'criteria_id' => 2],
            ['question_id' => 21, 'question_text' => 'Follows a syllabus/course outline as a guide for the lessons.', 'created_at' => Carbon::now(), 'question_code' => 'KM1', 'criteria_id' => 3],
            ['question_id' => 22, 'question_text' => 'Delivers the lessons confidently and with mastery.', 'created_at' => Carbon::now(), 'question_code' => 'KM2', 'criteria_id' => 3],
            ['question_id' => 23, 'question_text' => 'Relates subject matter to life situations and the world of work.', 'created_at' => Carbon::now(), 'question_code' => 'KM3', 'criteria_id' => 3],
            ['question_id' => 24, 'question_text' => 'Integrates Lycean values in teaching whenever relevant.', 'created_at' => Carbon::now(), 'question_code' => 'TP1', 'criteria_id' => 4],
            ['question_id' => 25, 'question_text' => 'Communicates clearly and correctly.', 'created_at' => Carbon::now(), 'question_code' => 'TP2', 'criteria_id' => 4],
            ['question_id' => 26, 'question_text' => 'Presents lessons in a clear and well-organized manner.', 'created_at' => Carbon::now(), 'question_code' => 'TP3', 'criteria_id' => 4],
            ['question_id' => 27, 'question_text' => 'In laboratory or clinical classes/on-the-job training, provides clear and well-organized pre-lab/pre-conference and post-lab/post-conference discussions.', 'created_at' => Carbon::now(), 'question_code' => 'TP4', 'criteria_id' => 4],
            ['question_id' => 28, 'question_text' => 'Uses varied teaching methods/strategies to effect learning.', 'created_at' => Carbon::now(), 'question_code' => 'TP5', 'criteria_id' => 4],
            ['question_id' => 29, 'question_text' => 'Shows effectiveness in the use of teaching strategies.', 'created_at' => Carbon::now(), 'question_code' => 'TP6', 'criteria_id' => 4],
            ['question_id' => 30, 'question_text' => 'Provides appropriate learning activities/practical applications to suit individual/group interests and capabilities, enhancing their academic and personal development.', 'created_at' => Carbon::now(), 'question_code' => 'TP7', 'criteria_id' => 4],
            ['question_id' => 31, 'question_text' => 'In laboratory or clinical classes/on-the-job training, encourages leadership skills toward independent practice.', 'created_at' => Carbon::now(), 'question_code' => 'TP8', 'criteria_id' => 4],
            ['question_id' => 32, 'question_text' => 'Uses alternative teaching aids such as films, illustrations, modules, AIMS, and internet information, when applicable.', 'created_at' => Carbon::now(), 'question_code' => 'TP9', 'criteria_id' => 4],
            ['question_id' => 33, 'question_text' => 'Assigns research/library work whenever relevant.', 'created_at' => Carbon::now(), 'question_code' => 'TP10', 'criteria_id' => 4],
            ['question_id' => 34, 'question_text' => 'Uses classroom and instructional resources effectively.', 'created_at' => Carbon::now(), 'question_code' => 'TP11', 'criteria_id' => 4],
            ['question_id' => 35, 'question_text' => 'Asks questions that promote critical and creative thinking skills.', 'created_at' => Carbon::now(), 'question_code' => 'TP12', 'criteria_id' => 4],
            ['question_id' => 36, 'question_text' => 'Encourages maximum student participation in the learning activities.', 'created_at' => Carbon::now(), 'question_code' => 'TP13', 'criteria_id' => 4],
            ['question_id' => 37, 'question_text' => 'Maintains a receptive and disciplined classroom/laboratory atmosphere.', 'created_at' => Carbon::now(), 'question_code' => 'TP14', 'criteria_id' => 4],
            ['question_id' => 38, 'question_text' => 'Provides adequate feedback mechanisms and applications to enhance learning.', 'created_at' => Carbon::now(), 'question_code' => 'TP15', 'criteria_id' => 4],
            ['question_id' => 39, 'question_text' => 'Evaluates students\' progress regularly and fairly (using valid and reliable tests and grading system).', 'created_at' => Carbon::now(), 'question_code' => 'TP16', 'criteria_id' => 4],
            ['question_id' => 40, 'question_text' => 'Optimizes the use of classroom time.', 'created_at' => Carbon::now(), 'question_code' => 'TP17', 'criteria_id' => 4],
            ['question_id' => 41, 'question_text' => 'Shows genuine concern towards students.', 'created_at' => Carbon::now(), 'question_code' => 'PD1', 'criteria_id' => 5],
            ['question_id' => 42, 'question_text' => 'Manifests openness to suggestions and criticisms.', 'created_at' => Carbon::now(), 'question_code' => 'PD2', 'criteria_id' => 5],
            ['question_id' => 43, 'question_text' => 'Exhibits fairness and impartiality in dealing with students.', 'created_at' => Carbon::now(), 'question_code' => 'PD3', 'criteria_id' => 5],
            ['question_id' => 44, 'question_text' => 'Observes proper teaching attire and grooming.', 'created_at' => Carbon::now(), 'question_code' => 'PD4', 'criteria_id' => 5],
            ['question_id' => 45, 'question_text' => 'Cooperates with and supports the goals, objectives, policies, programs, and activities of the College/Faculty/Department.', 'created_at' => Carbon::now(), 'question_code' => 'PD5', 'criteria_id' => 5],
            ['question_id' => 46, 'question_text' => 'Cooperates with and supports the goals, objectives, policies, programs, and activities of the University.', 'created_at' => Carbon::now(), 'question_code' => 'PD6', 'criteria_id' => 5],
            ['question_id' => 47, 'question_text' => 'Is committed to academic advancement and scholarly (research/creative) pursuits.', 'created_at' => Carbon::now(), 'question_code' => 'PD7', 'criteria_id' => 5],
            ['question_id' => 48, 'question_text' => 'Shows behavior consistent with the Code of Ethics, the University\'s norms of discipline, and sound moral standards.', 'created_at' => Carbon::now(), 'question_code' => 'PD8', 'criteria_id' => 5],
            ['question_id' => 49, 'question_text' => 'Relates professionally and harmoniously with Administrators.', 'created_at' => Carbon::now(), 'question_code' => 'PD9', 'criteria_id' => 5],
            ['question_id' => 50, 'question_text' => 'Relates professionally and harmoniously with Colleagues.', 'created_at' => Carbon::now(), 'question_code' => 'PD10', 'criteria_id' => 5],
            ['question_id' => 51, 'question_text' => 'Relates professionally and harmoniously with Students.', 'created_at' => Carbon::now(), 'question_code' => 'PD11', 'criteria_id' => 5],
            ['question_id' => 52, 'question_text' => 'Relates professionally and harmoniously with Support Staff.', 'created_at' => Carbon::now(), 'question_code' => 'PD12', 'criteria_id' => 5],
            ['question_id' => 53, 'question_text' => 'How well did your peer demonstrate effective communication skills?', 'created_at' => Carbon::now(), 'question_code' => 'CT1', 'criteria_id' => 6],
            ['question_id' => 54, 'question_text' => 'Did your peer actively listen and respond to others during discussions?', 'created_at' => Carbon::now(), 'question_code' => 'CT2', 'criteria_id' => 6],
            ['question_id' => 55, 'question_text' => 'How effectively did your peer convey their ideas to the group?', 'created_at' => Carbon::now(), 'question_code' => 'CT3', 'criteria_id' => 6],
            ['question_id' => 56, 'question_text' => 'Did your peer use appropriate language and tone when communicating?', 'created_at' => Carbon::now(), 'question_code' => 'CT4', 'criteria_id' => 6],
            ['question_id' => 57, 'question_text' => 'How well did your peer facilitate discussions to ensure everyone participated?', 'created_at' => Carbon::now(), 'question_code' => 'CT5', 'criteria_id' => 6],
            ['question_id' => 58, 'question_text' => 'How well did your peer manage their time during group projects?', 'created_at' => Carbon::now(), 'question_code' => 'CS1', 'criteria_id' => 7],
            ['question_id' => 59, 'question_text' => 'Was your peer effective in prioritizing tasks within the group?', 'created_at' => Carbon::now(), 'question_code' => 'CS2', 'criteria_id' => 7],
            ['question_id' => 60, 'question_text' => 'How consistently did your peer meet deadlines for their contributions?', 'created_at' => Carbon::now(), 'question_code' => 'CS3', 'criteria_id' => 7],
            ['question_id' => 61, 'question_text' => 'Did your peer proactively identify and address potential obstacles?', 'created_at' => Carbon::now(), 'question_code' => 'CS4', 'criteria_id' => 7],
            ['question_id' => 62, 'question_text' => 'How effectively did your peer balance workload among group members?', 'created_at' => Carbon::now(), 'question_code' => 'CS5', 'criteria_id' => 7],
            ['question_id' => 63, 'question_text' => 'How well do you understand your personal strengths?', 'created_at' => Carbon::now(), 'question_code' => 'SA1', 'criteria_id' => 8],
            ['question_id' => 64, 'question_text' => 'How often do you reflect on your weaknesses?', 'created_at' => Carbon::now(), 'question_code' => 'SA2', 'criteria_id' => 8],
            ['question_id' => 65, 'question_text' => 'To what extent do you recognize your impact on team dynamics?', 'created_at' => Carbon::now(), 'question_code' => 'SA3', 'criteria_id' => 8],
            ['question_id' => 66, 'question_text' => 'How do you evaluate your values and how they align with your actions?', 'created_at' => Carbon::now(), 'question_code' => 'SA4', 'criteria_id' => 8],
            ['question_id' => 67, 'question_text' => 'How effectively do you set and pursue personal goals?', 'created_at' => Carbon::now(), 'question_code' => 'SA5', 'criteria_id' => 8],
            ['question_id' => 68, 'question_text' => 'How regularly do you assess your progress towards your professional goals?', 'created_at' => Carbon::now(), 'question_code' => 'GA1', 'criteria_id' => 9],
            ['question_id' => 69, 'question_text' => 'How well do you identify obstacles that hinder your goal achievement?', 'created_at' => Carbon::now(), 'question_code' => 'GA2', 'criteria_id' => 9],
            ['question_id' => 70, 'question_text' => 'To what degree do you celebrate your successes?', 'created_at' => Carbon::now(), 'question_code' => 'GA3', 'criteria_id' => 9],
            ['question_id' => 71, 'question_text' => 'How often do you seek feedback to improve your performance?', 'created_at' => Carbon::now(), 'question_code' => 'GA4', 'criteria_id' => 9],
            ['question_id' => 72, 'question_text' => 'How committed are you to lifelong learning and personal development?', 'created_at' => Carbon::now(), 'question_code' => 'GA5', 'criteria_id' => 9],
        ]);
    }
}

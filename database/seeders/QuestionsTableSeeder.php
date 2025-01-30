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
            ['question_id' => 1, 'question_text' => 'States the objectives of the lesson/activities before the start of the class.','question_code' => 'TC1', 'criteria_id' => 1],
            ['question_id' => 2, 'question_text' => 'Orients the students on the planned activities for the day.','question_code' => 'TC2', 'criteria_id' => 1],
            ['question_id' => 3, 'question_text' => 'Adheres to school regulations on proper conduct/behavior.','question_code' => 'TC3', 'criteria_id' => 1],
            ['question_id' => 4, 'question_text' => 'Creates/Modifies appropriate activities as necessary.','question_code' => 'TC4', 'criteria_id' => 1],
            ['question_id' => 5, 'question_text' => 'Communicates ideas clearly and correctly.','question_code' => 'TC5', 'criteria_id' => 1],
            ['question_id' => 6, 'question_text' => 'Demonstrates teaching/laboratory skills with ease.','question_code' => 'TC6', 'criteria_id' => 1],
            ['question_id' => 7, 'question_text' => 'Uses teaching methods appropriate to the lesson/activity.','question_code' => 'TC7', 'criteria_id' => 1],
            ['question_id' => 8, 'question_text' => 'Gives appropriate comments or relevant feedbacks.','question_code' => 'TC8', 'criteria_id' => 1],
            ['question_id' => 9, 'question_text' => 'Provides opportunities for student participation.','question_code' => 'TC9', 'criteria_id' => 1],
            ['question_id' => 10, 'question_text' => 'Presents lesson/activities at a pace appropriate to student capability.','question_code' => 'TC10', 'criteria_id' => 1],
            ['question_id' => 11, 'question_text' => 'Provides examples that show application of concept.','question_code' => 'TC11', 'criteria_id' => 1],
            ['question_id' => 12, 'question_text' => 'Relates lesson/activities to other fields of knowledge.','question_code' => 'TC12', 'criteria_id' => 1],
            ['question_id' => 13, 'question_text' => 'Uses the medium of instruction as required by the course.','question_code' => 'TC13', 'criteria_id' => 1],
            ['question_id' => 15, 'question_text' => 'Informs students of their class performance.','question_code' => 'CM2', 'criteria_id' => 2],
            ['question_id' => 16, 'question_text' => 'Attends class regularly and punctually.','question_code' => 'CM3', 'criteria_id' => 2],
            ['question_id' => 17, 'question_text' => 'Uses time efficiently and effectively.','question_code' => 'CM4', 'criteria_id' => 2],
            ['question_id' => 18, 'question_text' => 'Checks attendance regularly.','question_code' => 'CM5', 'criteria_id' => 2],
            ['question_id' => 19, 'question_text' => 'Follows schedule for examination.','question_code' => 'CM6', 'criteria_id' => 2],
            ['question_id' => 20, 'question_text' => 'Creates an environment conducive for learning.','question_code' => 'CM7', 'criteria_id' => 2],
            ['question_id' => 21, 'question_text' => 'Follows a syllabus/course outline as a guide for the lessons.','question_code' => 'KM1', 'criteria_id' => 3],
            ['question_id' => 22, 'question_text' => 'Delivers the lessons confidently and with mastery.','question_code' => 'KM2', 'criteria_id' => 3],
            ['question_id' => 23, 'question_text' => 'Relates subject matter to life situations and the world of work.','question_code' => 'KM3', 'criteria_id' => 3],
            ['question_id' => 24, 'question_text' => 'Integrates Lycean values in teaching whenever relevant.','question_code' => 'TP1', 'criteria_id' => 4],
            ['question_id' => 25, 'question_text' => 'Communicates clearly and correctly.','question_code' => 'TP2', 'criteria_id' => 4],
            ['question_id' => 26, 'question_text' => 'Presents lessons in a clear and well-organized manner.','question_code' => 'TP3', 'criteria_id' => 4],
            ['question_id' => 27, 'question_text' => 'In laboratory or clinical classes/on-the-job training, provides clear and well-organized pre-lab/pre-conference and post-lab/post-conference discussions.','question_code' => 'TP4', 'criteria_id' => 4],
            ['question_id' => 28, 'question_text' => 'Uses varied teaching methods/strategies to effect learning.','question_code' => 'TP5', 'criteria_id' => 4],
            ['question_id' => 29, 'question_text' => 'Shows effectiveness in the use of teaching strategies.','question_code' => 'TP6', 'criteria_id' => 4],
            ['question_id' => 30, 'question_text' => 'Provides appropriate learning activities/practical applications to suit individual/group interests and capabilities, enhancing their academic and personal development.','question_code' => 'TP7', 'criteria_id' => 4],
            ['question_id' => 31, 'question_text' => 'In laboratory or clinical classes/on-the-job training, encourages leadership skills toward independent practice.','question_code' => 'TP8', 'criteria_id' => 4],
            ['question_id' => 32, 'question_text' => 'Uses alternative teaching aids such as films, illustrations, modules, AIMS, and internet information, when applicable.','question_code' => 'TP9', 'criteria_id' => 4],
            ['question_id' => 33, 'question_text' => 'Assigns research/library work whenever relevant.','question_code' => 'TP10', 'criteria_id' => 4],
            ['question_id' => 34, 'question_text' => 'Uses classroom and instructional resources effectively.','question_code' => 'TP11', 'criteria_id' => 4],
            ['question_id' => 35, 'question_text' => 'Asks questions that promote critical and creative thinking skills.','question_code' => 'TP12', 'criteria_id' => 4],
            ['question_id' => 36, 'question_text' => 'Encourages maximum student participation in the learning activities.','question_code' => 'TP13', 'criteria_id' => 4],
            ['question_id' => 37, 'question_text' => 'Maintains a receptive and disciplined classroom/laboratory atmosphere.','question_code' => 'TP14', 'criteria_id' => 4],
            ['question_id' => 38, 'question_text' => 'Provides adequate feedback mechanisms and applications to enhance learning.','question_code' => 'TP15', 'criteria_id' => 4],
            ['question_id' => 39, 'question_text' => 'Evaluates students\' progress regularly and fairly (using valid and reliable tests and grading system).','question_code' => 'TP16', 'criteria_id' => 4],
            ['question_id' => 40, 'question_text' => 'Optimizes the use of classroom time.','question_code' => 'TP17', 'criteria_id' => 4]
        ]);
    }
}

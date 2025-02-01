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
            [ 'position' => 1, 'question_id' => 1, 'question_text' => 'States the objectives of the lesson/activities before the start of the class.','criteria_id' => 1],
            [ 'position' => 2, 'question_id' => 2, 'question_text' => 'Orients the students on the planned activities for the day.','criteria_id' => 1],
            [ 'position' => 3, 'question_id' => 3, 'question_text' => 'Adheres to school regulations on proper conduct/behavior.','criteria_id' => 1],
            [ 'position' => 4, 'question_id' => 4, 'question_text' => 'Creates/Modifies appropriate activities as necessary.','criteria_id' => 1],
            [ 'position' => 5, 'question_id' => 5, 'question_text' => 'Communicates ideas clearly and correctly.','criteria_id' => 1],
            [ 'position' => 6, 'question_id' => 6, 'question_text' => 'Demonstrates teaching/laboratory skills with ease.','criteria_id' => 1],
            [ 'position' => 7, 'question_id' => 7, 'question_text' => 'Uses teaching methods appropriate to the lesson/activity.','criteria_id' => 1],
            [ 'position' => 8, 'question_id' => 8, 'question_text' => 'Gives appropriate comments or relevant feedbacks.','criteria_id' => 1],
            [ 'position' => 9, 'question_id' => 9, 'question_text' => 'Provides opportunities for student participation.','criteria_id' => 1],
            [ 'position' => 10, 'question_id' => 10, 'question_text' => 'Presents lesson/activities at a pace appropriate to student capability.', 'criteria_id' => 1],
            [ 'position' => 11, 'question_id' => 11, 'question_text' => 'Provides examples that show application of concept.', 'criteria_id' => 1],
            [ 'position' => 12, 'question_id' => 12, 'question_text' => 'Relates lesson/activities to other fields of knowledge.', 'criteria_id' => 1],
            [ 'position' => 13, 'question_id' => 13, 'question_text' => 'Uses the medium of instruction as required by the course.', 'criteria_id' => 1],
            
            [ 'position' => 1, 'question_id' => 15, 'question_text' => 'Informs students of their class performance.','criteria_id' => 2],
            [ 'position' => 2, 'question_id' => 16, 'question_text' => 'Attends class regularly and punctually.','criteria_id' => 2],
            [ 'position' => 3, 'question_id' => 17, 'question_text' => 'Uses time efficiently and effectively.','criteria_id' => 2],
            [ 'position' => 4, 'question_id' => 18, 'question_text' => 'Checks attendance regularly.','criteria_id' => 2],
            [ 'position' => 5, 'question_id' => 19, 'question_text' => 'Follows schedule for examination.','criteria_id' => 2],
            [ 'position' => 6, 'question_id' => 20, 'question_text' => 'Creates an environment conducive for learning.','criteria_id' => 2],

            [ 'position' => 1, 'question_id' => 21, 'question_text' => 'Follows a syllabus/course outline as a guide for the lessons.','criteria_id' => 3],
            [ 'position' => 2, 'question_id' => 22, 'question_text' => 'Delivers the lessons confidently and with mastery.','criteria_id' => 3],
            [ 'position' => 3, 'question_id' => 23, 'question_text' => 'Relates subject matter to life situations and the world of work.','criteria_id' => 3],
            
            [ 'position' => 1, 'question_id' => 24, 'question_text' => 'Integrates Lycean values in teaching whenever relevant.','criteria_id' => 4],
            [ 'position' => 2, 'question_id' => 25, 'question_text' => 'Communicates clearly and correctly.','criteria_id' => 4],
            [ 'position' => 3, 'question_id' => 26, 'question_text' => 'Presents lessons in a clear and well-organized manner.','criteria_id' => 4],
            [ 'position' => 4, 'question_id' => 27, 'question_text' => 'In laboratory or clinical classes/on-the-job training, provides clear and well-organized pre-lab/pre-conference and post-lab/post-conference discussions.','criteria_id' => 4],
            [ 'position' => 5, 'question_id' => 28, 'question_text' => 'Uses varied teaching methods/strategies to effect learning.','criteria_id' => 4],
            [ 'position' => 6, 'question_id' => 29, 'question_text' => 'Shows effectiveness in the use of teaching strategies.','criteria_id' => 4],
            [ 'position' => 7, 'question_id' => 30, 'question_text' => 'Provides appropriate learning activities/practical applications to suit individual/group interests and capabilities, enhancing their academic and personal development.','criteria_id' => 4],
            [ 'position' => 8, 'question_id' => 31, 'question_text' => 'In laboratory or clinical classes/on-the-job training, encourages leadership skills toward independent practice.','criteria_id' => 4],
            [ 'position' => 9, 'question_id' => 32, 'question_text' => 'Uses alternative teaching aids such as films, illustrations, modules, AIMS, and internet information, when applicable.','criteria_id' => 4],
            [ 'position' => 10, 'question_id' => 33, 'question_text' => 'Assigns research/library work whenever relevant.', 'criteria_id' => 4],
            [ 'position' => 11, 'question_id' => 34, 'question_text' => 'Uses classroom and instructional resources effectively.', 'criteria_id' => 4],
            [ 'position' => 12, 'question_id' => 35, 'question_text' => 'Asks questions that promote critical and creative thinking skills.', 'criteria_id' => 4],
            [ 'position' => 13, 'question_id' => 36, 'question_text' => 'Encourages maximum student participation in the learning activities.', 'criteria_id' => 4],
            [ 'position' => 14, 'question_id' => 37, 'question_text' => 'Maintains a receptive and disciplined classroom/laboratory atmosphere.', 'criteria_id' => 4],
            [ 'position' => 15, 'question_id' => 38, 'question_text' => 'Provides adequate feedback mechanisms and applications to enhance learning.', 'criteria_id' => 4],
            [ 'position' => 16, 'question_id' => 39, 'question_text' => 'Evaluates students\' progress regularly and fairly (using valid and reliable tests and grading system).', 'criteria_id' => 4],
            [ 'position' => 17, 'question_id' => 40, 'question_text' => 'Optimizes the use of classroom time.', 'criteria_id' => 4]
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionCriteriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Example data to be inserted
        $criteriaData = [
            ['description' => 'Teaching Competence', 'survey_id' => 1],
            ['description' => 'Classroom Management', 'survey_id' => 1],
            ['description' => 'Knowledge on the Subject Matter', 'survey_id' => 2],
            ['description' => 'Teaching Performance (Methods/Strategies, Classroom Management and Evaluation)', 'survey_id' => 2],
        ];
    
        foreach ($criteriaData as $data) {
            // Get the maximum position for the same survey_id and increment it
            $maxPosition = DB::table('question_criteria')->where('survey_id', $data['survey_id'])->max('position');
            
            // If no records exist, set position to 1, else increment the max position by 1
            $data['position'] = $maxPosition ? $maxPosition + 1 : 1;
    
            // Insert the record into the table
            DB::table('question_criteria')->insert([
                'description' => $data['description'],
                'survey_id' => $data['survey_id'],
                'position' => $data['position'],
            ]);
        }
    }
}

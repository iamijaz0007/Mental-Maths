<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaticQuestionAnswersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert Worksheets
        $worksheets = [
            ['name' => 'Worksheet 1', 'created_by' => 1, 'user_id' => 3, 'status' => 'incomplete'],
            ['name' => 'Worksheet 2', 'created_by' => 1, 'user_id' => 3, 'status' => 'incomplete'],
        ];

        DB::table('worksheets')->insert($worksheets);

        // Retrieve worksheet IDs for use in sections
        $worksheetIds = DB::table('worksheets')->pluck('id')->toArray();

        // Insert Sections for Worksheet 1 and Worksheet 2
        $sections = [
            ['worksheet_id' => $worksheetIds[0], 'name' => 'Addition Basics', 'subject' => 'Addition', 'difficulty_level' => 1],
            ['worksheet_id' => $worksheetIds[0], 'name' => 'Addition Intermediate', 'subject' => 'Addition', 'difficulty_level' => 2],
            ['worksheet_id' => $worksheetIds[0], 'name' => 'Addition Advanced', 'subject' => 'Addition', 'difficulty_level' => 3],
            ['worksheet_id' => $worksheetIds[0], 'name' => 'Subtraction Basics', 'subject' => 'Subtraction', 'difficulty_level' => 1],
            ['worksheet_id' => $worksheetIds[0], 'name' => 'Subtraction Intermediate', 'subject' => 'Subtraction', 'difficulty_level' => 2],
            ['worksheet_id' => $worksheetIds[0], 'name' => 'Subtraction Advanced', 'subject' => 'Subtraction', 'difficulty_level' => 3],
            ['worksheet_id' => $worksheetIds[0], 'name' => 'Multiplication Basics', 'subject' => 'Multiplication', 'difficulty_level' => 1],
            ['worksheet_id' => $worksheetIds[0], 'name' => 'Multiplication Intermediate', 'subject' => 'Multiplication', 'difficulty_level' => 2],
            ['worksheet_id' => $worksheetIds[0], 'name' => 'Multiplication Advanced', 'subject' => 'Multiplication', 'difficulty_level' => 3],
            ['worksheet_id' => $worksheetIds[0], 'name' => 'Division Basics', 'subject' => 'Division', 'difficulty_level' => 1],
            ['worksheet_id' => $worksheetIds[0], 'name' => 'Division Intermediate', 'subject' => 'Division', 'difficulty_level' => 2],
            ['worksheet_id' => $worksheetIds[0], 'name' => 'Division Advanced', 'subject' => 'Division', 'difficulty_level' => 3],
            // Insert Sections for Worksheet 2
            ['worksheet_id' => $worksheetIds[1], 'name' => 'Addition Basics', 'subject' => 'Addition', 'difficulty_level' => 1],
            ['worksheet_id' => $worksheetIds[1], 'name' => 'Addition Intermediate', 'subject' => 'Addition', 'difficulty_level' => 2],
            ['worksheet_id' => $worksheetIds[1], 'name' => 'Addition Advanced', 'subject' => 'Addition', 'difficulty_level' => 3],
            ['worksheet_id' => $worksheetIds[1], 'name' => 'Subtraction Basics', 'subject' => 'Subtraction', 'difficulty_level' => 1],
            ['worksheet_id' => $worksheetIds[1], 'name' => 'Subtraction Intermediate', 'subject' => 'Subtraction', 'difficulty_level' => 2],
            ['worksheet_id' => $worksheetIds[1], 'name' => 'Subtraction Advanced', 'subject' => 'Subtraction', 'difficulty_level' => 3],
            ['worksheet_id' => $worksheetIds[1], 'name' => 'Multiplication Basics', 'subject' => 'Multiplication', 'difficulty_level' => 1],
            ['worksheet_id' => $worksheetIds[1], 'name' => 'Multiplication Intermediate', 'subject' => 'Multiplication', 'difficulty_level' => 2],
            ['worksheet_id' => $worksheetIds[1], 'name' => 'Multiplication Advanced', 'subject' => 'Multiplication', 'difficulty_level' => 3],
            ['worksheet_id' => $worksheetIds[1], 'name' => 'Division Basics', 'subject' => 'Division', 'difficulty_level' => 1],
            ['worksheet_id' => $worksheetIds[1], 'name' => 'Division Intermediate', 'subject' => 'Division', 'difficulty_level' => 2],
            ['worksheet_id' => $worksheetIds[1], 'name' => 'Division Advanced', 'subject' => 'Division', 'difficulty_level' => 3],
        ];

        DB::table('sections')->insert($sections);

        // Retrieve section IDs for use in questions
        $sectionIds = DB::table('sections')->pluck('id')->toArray();

        // Insert Questions for Worksheet 1 and Worksheet 2
        $questions = [
            // Worksheet 1 - Addition
            ['worksheet_id' => $worksheetIds[0], 'section_id' => $sectionIds[0], 'question_text' => 'What is 3 + 2?', 'difficulty' => 'easy', 'correct_answer' => '5'],
            ['worksheet_id' => $worksheetIds[0], 'section_id' => $sectionIds[0], 'question_text' => 'What is 5 + 4?', 'difficulty' => 'easy', 'correct_answer' => '9'],
            ['worksheet_id' => $worksheetIds[0], 'section_id' => $sectionIds[1], 'question_text' => 'What is 12 + 7?', 'difficulty' => 'medium', 'correct_answer' => '19'],
            ['worksheet_id' => $worksheetIds[0], 'section_id' => $sectionIds[1], 'question_text' => 'What is 23.32 + 32.43?', 'difficulty' => 'medium', 'correct_answer' => '55.75'],
            ['worksheet_id' => $worksheetIds[0], 'section_id' => $sectionIds[2], 'question_text' => 'Solve for x: x + 7 = 15', 'difficulty' => 'hard', 'correct_answer' => '8'],

            // Worksheet 1 - Subtraction
            ['worksheet_id' => $worksheetIds[0], 'section_id' => $sectionIds[3], 'question_text' => 'What is 5 - 2?', 'difficulty' => 'easy', 'correct_answer' => '3'],
            ['worksheet_id' => $worksheetIds[0], 'section_id' => $sectionIds[3], 'question_text' => 'What is 7 - 3?', 'difficulty' => 'easy', 'correct_answer' => '4'],
            ['worksheet_id' => $worksheetIds[0], 'section_id' => $sectionIds[4], 'question_text' => 'What is 15 - 7?', 'difficulty' => 'medium', 'correct_answer' => '8'],
            ['worksheet_id' => $worksheetIds[0], 'section_id' => $sectionIds[4], 'question_text' => 'What is 34.75 - 12.56?', 'difficulty' => 'medium', 'correct_answer' => '22.19'],
            ['worksheet_id' => $worksheetIds[0], 'section_id' => $sectionIds[5], 'question_text' => 'Solve for x: 2x - 10 = 30', 'difficulty' => 'hard', 'correct_answer' => '20'],

            // Worksheet 1 - Multiplication
            ['worksheet_id' => $worksheetIds[0], 'section_id' => $sectionIds[6], 'question_text' => 'What is 3 x 2?', 'difficulty' => 'easy', 'correct_answer' => '6'],
            ['worksheet_id' => $worksheetIds[0], 'section_id' => $sectionIds[6], 'question_text' => 'What is 5 x 4?', 'difficulty' => 'easy', 'correct_answer' => '20'],
            ['worksheet_id' => $worksheetIds[0], 'section_id' => $sectionIds[7], 'question_text' => 'What is 12 x 7?', 'difficulty' => 'medium', 'correct_answer' => '84'],
            ['worksheet_id' => $worksheetIds[0], 'section_id' => $sectionIds[7], 'question_text' => 'What is 7.5 x 3.2?', 'difficulty' => 'medium', 'correct_answer' => '24.0'],
            ['worksheet_id' => $worksheetIds[0], 'section_id' => $sectionIds[8], 'question_text' => 'Solve for x: 4x = 36', 'difficulty' => 'hard', 'correct_answer' => '9'],

            // Worksheet 1 - Division
            ['worksheet_id' => $worksheetIds[0], 'section_id' => $sectionIds[9], 'question_text' => 'What is 6 ÷ 2?', 'difficulty' => 'easy', 'correct_answer' => '3'],
            ['worksheet_id' => $worksheetIds[0], 'section_id' => $sectionIds[9], 'question_text' => 'What is 8 ÷ 4?', 'difficulty' => 'easy', 'correct_answer' => '2'],
            ['worksheet_id' => $worksheetIds[0], 'section_id' => $sectionIds[10], 'question_text' => 'What is 36 ÷ 6?', 'difficulty' => 'medium', 'correct_answer' => '6'],
            ['worksheet_id' => $worksheetIds[0], 'section_id' => $sectionIds[10], 'question_text' => 'What is 45.6 ÷ 3.6?', 'difficulty' => 'medium', 'correct_answer' => '12.67'],
            ['worksheet_id' => $worksheetIds[0], 'section_id' => $sectionIds[11], 'question_text' => 'Solve for x: 9x = 81', 'difficulty' => 'hard', 'correct_answer' => '9'],

            // Questions for Worksheet 2
            // Addition Questions
            ['worksheet_id' => $worksheetIds[1], 'section_id' => $sectionIds[12], 'question_text' => 'What is 6 + 7?', 'difficulty' => 'easy', 'correct_answer' => '13'],
            ['worksheet_id' => $worksheetIds[1], 'section_id' => $sectionIds[12], 'question_text' => 'What is 8 + 5?', 'difficulty' => 'easy', 'correct_answer' => '13'],
            ['worksheet_id' => $worksheetIds[1], 'section_id' => $sectionIds[13], 'question_text' => 'What is 17 + 8?', 'difficulty' => 'medium', 'correct_answer' => '25'],
            ['worksheet_id' => $worksheetIds[1], 'section_id' => $sectionIds[13], 'question_text' => 'What is 45.67 + 23.89?', 'difficulty' => 'medium', 'correct_answer' => '69.56'],
            ['worksheet_id' => $worksheetIds[1], 'section_id' => $sectionIds[14], 'question_text' => 'Solve for x: 2x + 5 = 25', 'difficulty' => 'hard', 'correct_answer' => '10'],

            // Subtraction Questions
            ['worksheet_id' => $worksheetIds[1], 'section_id' => $sectionIds[15], 'question_text' => 'What is 9 - 3?', 'difficulty' => 'easy', 'correct_answer' => '6'],
            ['worksheet_id' => $worksheetIds[1], 'section_id' => $sectionIds[15], 'question_text' => 'What is 10 - 7?', 'difficulty' => 'easy', 'correct_answer' => '3'],
            ['worksheet_id' => $worksheetIds[1], 'section_id' => $sectionIds[16], 'question_text' => 'What is 20 - 9?', 'difficulty' => 'medium', 'correct_answer' => '11'],
            ['worksheet_id' => $worksheetIds[1], 'section_id' => $sectionIds[16], 'question_text' => 'What is 78.90 - 23.45?', 'difficulty' => 'medium', 'correct_answer' => '55.45'],
            ['worksheet_id' => $worksheetIds[1], 'section_id' => $sectionIds[17], 'question_text' => 'Solve for x: 3x - 4 = 20', 'difficulty' => 'hard', 'correct_answer' => '8'],

            // Multiplication Questions
            ['worksheet_id' => $worksheetIds[1], 'section_id' => $sectionIds[18], 'question_text' => 'What is 4 x 5?', 'difficulty' => 'easy', 'correct_answer' => '20'],
            ['worksheet_id' => $worksheetIds[1], 'section_id' => $sectionIds[18], 'question_text' => 'What is 6 x 7?', 'difficulty' => 'easy', 'correct_answer' => '42'],
            ['worksheet_id' => $worksheetIds[1], 'section_id' => $sectionIds[19], 'question_text' => 'What is 15 x 4?', 'difficulty' => 'medium', 'correct_answer' => '60'],
            ['worksheet_id' => $worksheetIds[1], 'section_id' => $sectionIds[19], 'question_text' => 'What is 9.5 x 4.2?', 'difficulty' => 'medium', 'correct_answer' => '39.9'],
            ['worksheet_id' => $worksheetIds[1], 'section_id' => $sectionIds[20], 'question_text' => 'Solve for x: 5x = 100', 'difficulty' => 'hard', 'correct_answer' => '20'],

            // Division Questions
            ['worksheet_id' => $worksheetIds[1], 'section_id' => $sectionIds[21], 'question_text' => 'What is 12 ÷ 4?', 'difficulty' => 'easy', 'correct_answer' => '3'],
            ['worksheet_id' => $worksheetIds[1], 'section_id' => $sectionIds[21], 'question_text' => 'What is 15 ÷ 5?', 'difficulty' => 'easy', 'correct_answer' => '3'],
            ['worksheet_id' => $worksheetIds[1], 'section_id' => $sectionIds[22], 'question_text' => 'What is 48 ÷ 8?', 'difficulty' => 'medium', 'correct_answer' => '6'],
            ['worksheet_id' => $worksheetIds[1], 'section_id' => $sectionIds[22], 'question_text' => 'What is 72.0 ÷ 6.0?', 'difficulty' => 'medium', 'correct_answer' => '12.0'],
            ['worksheet_id' => $worksheetIds[1], 'section_id' => $sectionIds[23], 'question_text' => 'Solve for x: 4x = 64', 'difficulty' => 'hard', 'correct_answer' => '16'],
        ];

        DB::table('questions')->insert($questions);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PracticeWorksheetController extends Controller
{
    public function worksheet()
    {
        // Define sample questions with answers
        // Define sample questions with answers
        $questions = [
            // Easy Questions (20 Questions)
            ['question' => '5 + 3 = ?', 'correct_answer' => 8],
            ['question' => '10 - 7 = ?', 'correct_answer' => 3],
            ['question' => '6 * 2 = ?', 'correct_answer' => 12],
            ['question' => '9 / 3 = ?', 'correct_answer' => 3],
            ['question' => '8 + 2 = ?', 'correct_answer' => 10],
            ['question' => '12 - 5 = ?', 'correct_answer' => 7],
            ['question' => '7 * 1 = ?', 'correct_answer' => 7],
            ['question' => '15 / 5 = ?', 'correct_answer' => 3],
            ['question' => '4 + 6 = ?', 'correct_answer' => 10],
            ['question' => '8 - 3 = ?', 'correct_answer' => 5],
            ['question' => '7 + 2 = ?', 'correct_answer' => 9],
            ['question' => '10 / 2 = ?', 'correct_answer' => 5],
            ['question' => '3 + 4 = ?', 'correct_answer' => 7],
            ['question' => '9 - 5 = ?', 'correct_answer' => 4],
            ['question' => '6 * 1 = ?', 'correct_answer' => 6],
            ['question' => '8 / 4 = ?', 'correct_answer' => 2],
            ['question' => '7 + 3 = ?', 'correct_answer' => 10],
            ['question' => '10 - 6 = ?', 'correct_answer' => 4],
            ['question' => '2 * 5 = ?', 'correct_answer' => 10],
            ['question' => '12 / 6 = ?', 'correct_answer' => 2],

            // Moderate Difficulty (20 Questions)
            ['question' => '8 + 4 / 2 = ?', 'correct_answer' => 10], // Divides first, then adds
            ['question' => '15 - 3 * 2 = ?', 'correct_answer' => 9],  // Multiplication before subtraction
            ['question' => '12 + (8 / 4) = ?', 'correct_answer' => 14], // Parentheses first
            ['question' => '18 / (3 + 3) = ?', 'correct_answer' => 3],  // Parentheses first
            ['question' => '25 - (5 * 3) + 4 = ?', 'correct_answer' => 14], // Multiple operations with parentheses
            ['question' => '6 + 8 / 4 * 2 = ?', 'correct_answer' => 10],
            ['question' => '10 + 12 / 4 = ?', 'correct_answer' => 13],
            ['question' => '16 / (4 + 4) = ?', 'correct_answer' => 2],
            ['question' => '14 - 3 * 2 + 1 = ?', 'correct_answer' => 9],
            ['question' => '8 * 2 + 6 = ?', 'correct_answer' => 22],
            ['question' => '25 / 5 + 4 = ?', 'correct_answer' => 9],
            ['question' => '18 - 4 / 2 = ?', 'correct_answer' => 16],
            ['question' => '30 / (3 * 2) = ?', 'correct_answer' => 5],
            ['question' => '28 / (7 + 7) = ?', 'correct_answer' => 2],
            ['question' => '45 - (5 * 6) = ?', 'correct_answer' => 15],
            ['question' => '60 / (3 * 5) = ?', 'correct_answer' => 4],
            ['question' => '16 + (8 / 2) = ?', 'correct_answer' => 20],
            ['question' => '40 - 10 / 2 = ?', 'correct_answer' => 35],
            ['question' => '20 + 12 / (3 * 2) = ?', 'correct_answer' => 22],
            ['question' => '50 - (10 + 5) = ?', 'correct_answer' => 35],

            // Advanced Difficulty (20 Questions)
            ['question' => '(2 + 3) * (5 - 2) = ?', 'correct_answer' => 15], // Brackets and multiplication
            ['question' => '2^3 + 4 = ?', 'correct_answer' => 12], // Exponentiation followed by addition
            ['question' => 'sqrt(49) + 3 = ?', 'correct_answer' => 10], // Square root then addition
            ['question' => '(12 + 4) / (3 * 2) = ?', 'correct_answer' => 2], // Division with multiple steps
            ['question' => '(3^2 + 4^2) = ?', 'correct_answer' => 25], // Pythagorean triple (3, 4, 5 triangle)
            ['question' => '(5 + 7) * (6 - 3) = ?', 'correct_answer' => 36],
            ['question' => '2^4 + (8 / 2) = ?', 'correct_answer' => 20],
            ['question' => 'sqrt(64) * 3 = ?', 'correct_answer' => 24],
            ['question' => '3^2 * 2 - 4 = ?', 'correct_answer' => 14],
            ['question' => '(5 + 6) * (7 - 2) = ?', 'correct_answer' => 55],
            ['question' => 'sqrt(81) + 2^3 = ?', 'correct_answer' => 17],
            ['question' => '(10^2 / 5) + 6 = ?', 'correct_answer' => 26],
            ['question' => '(20 / 2) + (3 * 5) = ?', 'correct_answer' => 35],
            ['question' => '(8 * 2) / (4 - 2) = ?', 'correct_answer' => 8],
            ['question' => '3^3 + sqrt(16) = ?', 'correct_answer' => 31],
            ['question' => '(12 + 8) / 4 = ?', 'correct_answer' => 5],
            ['question' => '5^2 - 6 + 2 = ?', 'correct_answer' => 21],
            ['question' => '(9^2 / 3) - 7 = ?', 'correct_answer' => 20],
            ['question' => 'sqrt(144) + 5^2 = ?', 'correct_answer' => 49],
            ['question' => '(30 / 5) + 2^4 = ?', 'correct_answer' => 22]
        ];


        // Randomly pick 3 questions
        $randomQuestions = collect($questions)->random(10);

        return view('practice-worksheet.start', ['questions' => $randomQuestions]);
    }

    public function submit(Request $request)
    {
        $submittedAnswers = $request->input('answers');
        $correctAnswers = $request->input('correct_answers');
        $score = 0;
        $results = [];

        // Loop through the submitted answers and compare them with the correct answers
        foreach ($submittedAnswers as $index => $answer) {
            $results[] = [
                'question' => $request->input('questions')[$index], // Get question text
                'submitted_answer' => $answer,
                'correct_answer' => $correctAnswers[$index],
                'is_correct' => $answer == $correctAnswers[$index],
            ];

            if ($answer == $correctAnswers[$index]) {
                $score++;
            }
        }

        // Return the result view with the score and details of each question
        return view('practice-worksheet.result', compact('score', 'results', 'submittedAnswers', 'correctAnswers'));
    }
}

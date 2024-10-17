<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use App\Models\Worksheet;
use Illuminate\Support\Facades\Auth;
use App\Models\SectionProgress;
use App\Models\User;
use App\Models\ErrorReport;
use App\Models\StudentProgress;
use Illuminate\Support\Facades\DB;


class WorksheetController extends Controller
{

//    for admin
    public function index()
    {
        $worksheets = Worksheet::with('sections')->get(); // Eager load sections

        return view('worksheet.index', compact('worksheets'));
    }

    public function add()
    {
        return view('worksheet.create');
    }

    public function show($id)
    {
        $worksheet = Worksheet::with('sections.questions')->findOrFail($id);

        return view('worksheet.show', compact('worksheet'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create the worksheet once
        $worksheet = Worksheet::create([
            'name' => $request->name,
            'created_by' => Auth::id(), // Admin who creates the worksheet
        ]);

        // Get all students (users with role 3)
        $students = User::where('role', 3)->get();

        // Check if any students were found
        if ($students->isEmpty()) {
            return redirect()->back()->with('error', 'No students found to assign the worksheet.');
        }

        // Associate the worksheet with all students in the pivot table
        foreach ($students as $student) {
            DB::table('student_worksheet')->insert([
                'worksheet_id' => $worksheet->id,
                'user_id' => $student->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Redirect to sections.create route and pass the worksheet ID
        return redirect()->route('sections.create', ['worksheet' => $worksheet->id])
            ->with('success', 'Worksheet created successfully and assigned to students! Now you can add sections.');
    }



    public function edit($id)
    {
        $worksheet = Worksheet::findOrFail($id);

        return view('worksheet.edit', compact('worksheet'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $worksheet = Worksheet::findOrFail($id);
        $worksheet->update($request->all());

        return redirect()->route('worksheet.index')->with('success', 'Worksheet updated successfully!');
    }

    public function destroy($id)
    {
        $worksheet = Worksheet::findOrFail($id);
        $worksheet->delete();

        return redirect()->route('worksheet.index')->with('success', 'Worksheet deleted successfully!');
    }



//    for student worksheet
    public function worksheet_list()
    {
        $user = Auth::user();

        // Check if the user is either an admin or a student
        if (!in_array($user->role, [1, 3])) {
            abort(403, 'Unauthorized access.');
        }

        // Fetch all worksheets that the student has access to
        $worksheets = Worksheet::orderBy('id')->get(); // Fetch all worksheets since worksheets are shared among students

        // Initialize the worksheet progress array
        $worksheetProgress = [];

        foreach ($worksheets as $worksheet) {
            // Total sections in the worksheet
            $totalSections = $worksheet->sections()->count();

            // Completed sections for this specific user
            $completedSections = SectionProgress::where('user_id', $user->id)
                ->where('worksheet_id', $worksheet->id)
                ->where('completed', true)
                ->count();

            // Add progress data for the worksheet
            $worksheetProgress[$worksheet->id] = [
                'totalSections' => $totalSections,
                'completedSections' => $completedSections,
                'remainingSections' => $totalSections - $completedSections,
            ];

            // Mark worksheet as completed if all sections are done
            $worksheet->is_completed = ($completedSections === $totalSections);
        }

        return view('worksheet.worksheet_list', [
            'worksheets' => $worksheets,
            'worksheetProgress' => $worksheetProgress,
        ]);
    }




    public function student_worksheet($worksheetId, $sectionId = null)
    {
        $user = Auth::user();

        // Check if the user is a student
        if ($user->role != 3) {
            return redirect()->route('worksheet.index')->with('error', 'Access denied. Only students can start the worksheet.');
        }

        // Fetch the worksheet and its sections with questions
        $worksheet = Worksheet::with('sections.questions')->findOrFail($worksheetId);

        // Ensure that progress exists for each section of the worksheet
        foreach ($worksheet->sections as $section) {
            SectionProgress::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'worksheet_id' => $worksheetId,
                    'section_id' => $section->id
                ],
                [
                    'completed' => false,
                ]
            );
        }

        // If no specific section is provided, find the first uncompleted section for the user
        if (!$sectionId) {
            $progress = SectionProgress::where('user_id', $user->id)
                ->where('worksheet_id', $worksheetId)
                ->where('completed', false)
                ->first();

            if ($progress) {
                $sectionId = $progress->section_id;
            } else {
                return redirect()->back()->with('error', 'No uncompleted section found.');
            }
        }

        // Find the specific section for the worksheet
        $section = $worksheet->sections()->find($sectionId);

        if (!$section) {
            return redirect()->back()->with('error', 'Section not found.');
        }

        // Shuffle questions within difficulty groups
        $easyQuestions = $section->questions->where('difficulty', 'easy')->shuffle();
        $intermediateQuestions = $section->questions->where('difficulty', 'medium')->shuffle();
        $hardQuestions = $section->questions->where('difficulty', 'hard')->shuffle();

        // Limit the number of questions from each difficulty level
        $selectedEasyQuestions = $easyQuestions->take(2);
        $selectedIntermediateQuestions = $intermediateQuestions->take(2);
        $selectedHardQuestions = $hardQuestions->take(1);

        // Combine the questions without shuffling the final set
        $questions = $selectedEasyQuestions
            ->concat($selectedIntermediateQuestions)
            ->concat($selectedHardQuestions);

        // Calculate remaining sections
        $totalSections = $worksheet->sections()->count();
        $completedSections = SectionProgress::where('user_id', $user->id)
            ->where('worksheet_id', $worksheetId)
            ->where('completed', true)
            ->count();
        $remainingSections = $totalSections - $completedSections - 1; // Adjusted to -1 for correct calculation

        return view('worksheet.student_worksheet', compact('worksheet', 'section', 'questions', 'completedSections', 'remainingSections'));
    }


    public function submit_section(Request $request, $worksheetId, $sectionId)
    {
        $user = Auth::user();
        $worksheet = Worksheet::findOrFail($worksheetId);
        $section = $worksheet->sections()->findOrFail($sectionId);
        $incorrectAnswers = [];
        $correctAnswers = 0;

        // Track the time taken for the section
        $sectionTimeTaken = $request->input('time_taken');

        // Loop through each question's answer submitted by the student
        foreach ($request->answers as $questionId => $studentAnswer) {
            $question = $section->questions()->findOrFail($questionId);

            // Determine if the student's answer is correct
            $isCorrect = $this->checkIfCorrect($question, $studentAnswer);

            // Store the answer in the database
            $answer = Answer::updateOrCreate(
                [
                    'question_id' => $question->id,
                    'user_id' => $user->id,
                    'worksheet_id' => $worksheetId,
                ],
                [
                    'student_answer' => $studentAnswer,
                    'is_correct' => $isCorrect,
                ]
            );

            // Track correct/incorrect answers for logging
            if ($isCorrect) {
                $correctAnswers++;
            } else {
                $incorrectAnswers[] = $question->id;
            }
        }

        // Mark the section as completed
        SectionProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'worksheet_id' => $worksheetId,
                'section_id' => $sectionId,
            ],
            [
                'completed' => true,
                'time_taken' => $sectionTimeTaken, // Record section time
            ]
        );

        // Update the student progress table
        $studentProgress = StudentProgress::firstOrCreate(
            [
                'user_id' => $user->id,
                'worksheet_id' => $worksheetId,
            ],
            [
                'total_sections' => $worksheet->sections()->count(),
                'total_worksheets' => Worksheet::where('user_id', $user->id)->count(),
            ]
        );

        // Update the progress data
        $studentProgress->update([
            'completed_sections' => SectionProgress::where('user_id', $user->id)
                ->where('worksheet_id', $worksheetId)
                ->where('completed', true)
                ->count(),
            'correct_questions' => $studentProgress->correct_questions + $correctAnswers,
            'incorrect_questions' => $studentProgress->incorrect_questions + count($incorrectAnswers),
            'time_spent_on_sections' => $studentProgress->time_spent_on_sections + $sectionTimeTaken,
        ]);

        // Check if all sections are completed
        $totalSections = $worksheet->sections()->count();
        $completedSections = SectionProgress::where('user_id', $user->id)
            ->where('worksheet_id', $worksheetId)
            ->where('completed', true)
            ->count();

        // If all sections are completed, update the progress for the worksheet
        if ($completedSections === $totalSections) {
            // Mark the worksheet as completed
            $worksheet->update(['completed' => true]);

            // Calculate total time spent on the worksheet
            $totalTimeSpent = SectionProgress::where('user_id', $user->id)
                ->where('worksheet_id', $worksheetId)
                ->sum('time_taken');

            // Update the student's progress with the total worksheet time
            $studentProgress->update([
                'completed_worksheets' => $studentProgress->completed_worksheets + 1,
                'total_time_spent_on_worksheets' => $studentProgress->total_time_spent_on_worksheets + $totalTimeSpent,
            ]);

            // Check for incorrect answers and redirect accordingly
            $incorrectAnswersInWorksheet = Answer::where('worksheet_id', $worksheetId)
                ->where('user_id', $user->id)
                ->where('is_correct', false)
                ->count();

            if ($incorrectAnswersInWorksheet > 0) {
                return redirect()->route('worksheet.correction', ['worksheet' => $worksheetId])
                    ->with('success', 'Worksheet completed, but some answers were incorrect. Please correct them.');
            }

            return redirect()->route('worksheet.error_report_confirmation', ['worksheet' => $worksheetId])
                ->with('success', 'Worksheet completed successfully! You can report any errors if needed.');
        }

        // Move to the next section if there are more sections
        if ($request->input('action') === 'next') {
            $nextSection = $worksheet->sections()->where('id', '>', $sectionId)->first();
            if ($nextSection) {
                return redirect()->route('worksheet.student_worksheet', ['worksheet' => $worksheetId, 'section' => $nextSection->id]);
            }
        }

        return redirect()->route('worksheet.worksheet_list')->with('success', 'Section submitted successfully!');
    }

    private function checkIfCorrect($question, $studentAnswer)
    {
        return $question->correct_answer === $studentAnswer;
    }


// for corrction worksheet
    public function showCorrection($worksheetId)
    {
        $user = Auth::user();

        // Fetch the worksheet and its sections with incorrect answers
        $worksheet = Worksheet::findOrFail($worksheetId);

        // Get only the incorrect answers that were not corrected yet
        $incorrectAnswers = Answer::where('user_id', $user->id)
            ->where('worksheet_id', $worksheetId)
            ->where('is_correct', false) // Only get incorrect answers
            ->with('question') // Include the related question
            ->get();

        // Pass the incorrect answers and their corresponding correct answers to the view
        return view('worksheet.correction', compact('worksheet', 'incorrectAnswers'));
    }


    public function submitCorrection(Request $request, $worksheetId)
    {
        $user = Auth::user();
        $errors = [];

        foreach ($request->answers as $questionId => $correctedAnswer) {
            $answer = Answer::where('user_id', $user->id)
                ->where('worksheet_id', $worksheetId)
                ->where('question_id', $questionId)
                ->firstOrFail();

            // Check if the corrected answer is correct
            $isCorrect = $this->checkIfCorrect($answer->question, $correctedAnswer);

            // Update only the `is_correct` field and the student's answer
            $answer->update([
                'student_answer' => $correctedAnswer,
                'is_correct' => $isCorrect, // Mark as correct or incorrect
            ]);

            // If the answer is still wrong, store the error
            if (!$isCorrect) {
                $errors[] = $answer->question->question_text;
            }
        }

        // If there are still errors, redirect back to the correction form with the error message
        if (!empty($errors)) {
            return redirect()->back()->with('error', 'Some answers are still incorrect. Please correct the following questions: ' . implode(', ', $errors));
        }

        // If all answers are correct, redirect to the error report confirmation page
        return redirect()->route('worksheet.error_report_confirmation', ['worksheet' => $worksheetId])
            ->with('success', 'Corrections submitted successfully! You can now report any errors if needed.');
    }


    public function showErrorReportConfirmation($worksheetId)
    {
        $worksheet = Worksheet::findOrFail($worksheetId);

        return view('worksheet.error_report_confirmation', compact('worksheet'));
    }



    public function showErrorReportForm($worksheetId)
    {
        $worksheet = Worksheet::findOrFail($worksheetId);

        return view('worksheet.error_report', compact('worksheet'));
    }

    public function submitErrorReport(Request $request, $worksheetId)
    {
        $request->validate([
            'error_message' => 'required|string|max:1000',
        ]);

        // Store the error report
        ErrorReport::create([
            'user_id' => Auth::id(),
            'worksheet_id' => $worksheetId,
            'error_message' => $request->input('error_message'),
        ]);

        return redirect()->route('worksheet.worksheet_list')->with('success', 'Your error report has been submitted successfully.');
    }

    public function getStudentNotifications()
    {
        $user = Auth::user();

        // Fetch error reports that have been responded to by the admin
        $errorReports = ErrorReport::where('user_id', $user->id)
            ->where(function($query) {
                $query->whereNotNull('admin_response')
                    ->orWhere('status', 'not_an_error'); // Include status if necessary
            })
            ->latest()
            ->get();

        return view('student.notifications', compact('errorReports'));
    }


    public function confirm_submission($worksheetId)
    {
        $worksheet = Worksheet::findOrFail($worksheetId);
        $incompleteSections = $worksheet->sections->where('completed', false)->count();

        // Check if sections are incomplete
        if ($incompleteSections > 0) {
            return view('worksheet.confirm_submission', compact('worksheet'));
        }

        return redirect()->route('worksheet.student_worksheet', ['worksheet' => $worksheetId]);
    }

    public function submit_worksheet(Request $request, $worksheetId)
    {
        $user = Auth::user();
        $worksheet = Worksheet::findOrFail($worksheetId);

        // Mark the worksheet as completed
        $worksheet->update(['status' => 'completed']);

        return redirect()->route('worksheet.worksheet_list')->with('success', 'Worksheet submitted successfully!');
    }


}

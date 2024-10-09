<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Worksheet;
use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    public function create($sectionId)
{
    $section = Section::findOrFail($sectionId); // Retrieve the section

    // Retrieve the worksheet associated with this section
    $worksheet = $section->worksheet;

    return view('questions.create', compact('section', 'worksheet')); // Pass the section and worksheet to the view
}



    public function store(Request $request, $worksheetId, $sectionId)
{
    // Validate the request
    $request->validate([
        'question_text' => 'required|string',
        'difficulty' => 'required|string|in:easy,medium,hard',
        'correct_answer' => 'required|string',
    ]);

    // Check if the worksheet exists
    $worksheet = Worksheet::find($worksheetId);
    if (!$worksheet) {
        return redirect()->back()->withErrors(['error' => 'Worksheet not found.']);
    }

    // Create a new question and associate it with the worksheet and section
    Question::create([
        'worksheet_id' => $worksheet->id,
        'section_id' => $sectionId,
        'question_text' => $request->question_text,
        'difficulty' => $request->difficulty,
        'correct_answer' => $request->correct_answer,
    ]);

    return redirect()->route('questions.create', ['worksheet' => $worksheetId, 'section' => $sectionId])
        ->with('success', 'Question added successfully to the worksheet! Add another one.');
}


    public function edit($id)
    {
        $question = Question::findOrFail($id);
        return view('questions.edit', compact('question'));
    }

    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);

        $request->validate([
            'question_text' => 'required|string',
            'correct_answer' => 'required|string',
            'difficulty' => 'required|string|in:easy,medium,hard',
        ]);

        $question->update([
            'question_text' => $request->question_text,
            'correct_answer' => $request->correct_answer,
            'difficulty' => $request->difficulty,
        ]);

        return redirect()->route('worksheet.show', $question->section->worksheet_id)
            ->with('success', 'Question updated successfully!');
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return redirect()->back()->with('success', 'Question deleted successfully!');
    }




}

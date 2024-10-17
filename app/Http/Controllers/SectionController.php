<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Worksheet;
use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{

    public function create($worksheetId)
    {
        // Fetch the worksheet by ID
        $worksheet = Worksheet::findOrFail($worksheetId);

        // Pass the worksheet to the view
        return view('sections.create', compact('worksheet'));
    }

    public function store(Request $request, $worksheetId)
    {
        // Validate the request data
        $request->validate([
            'subject' => 'required|string|max:255',
            'difficulty_level' => 'required|integer|in:1,2,3',
        ]);

        // Create the section (only once)
        $section = Section::create([
            'worksheet_id' => $worksheetId,
            'subject' => $request->subject,
            'difficulty_level' => $request->difficulty_level,
        ]);

        // Get all students (users with role 3)
        $students = User::where('role', 3)->get();

        // Check if any students were found
        if ($students->isEmpty()) {
            return redirect()->back()->with('error', 'No students found to assign the section.');
        }

        // Assign the section to all students by inserting into the pivot table
        foreach ($students as $student) {
            // Insert into the section_student table
            DB::table('section_student')->insert([
                'section_id' => $section->id,
                'user_id' => $student->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('worksheet.show', $worksheetId)->with('success', 'Section added successfully and assigned to all students!');
    }



    public function edit($id)
    {
        $section = Section::findOrFail($id);

        return view('sections.edit', compact('section'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'subject' => 'required|string|max:255',
            'difficulty_level' => 'required|integer|min:1|max:5',
        ]);

        // Find the section by ID
        $section = Section::findOrFail($id);

        // Update the section with the new data
        $section->update($request->all());

        // Redirect back to the worksheet's show page
        return redirect()->route('worksheet.show', $section->worksheet_id)->with('success', 'Section updated successfully!');
    }


    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();

        return redirect()->back()->with('success', 'Section deleted successfully!');
    }


}

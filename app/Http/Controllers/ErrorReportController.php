<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorReportController extends Controller
{
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'worksheet_id' => 'required|exists:worksheets,id',
            'section_id' => 'required|exists:sections,id',
            'description' => 'required|string',
        ]);

        // Create a new error report
        ErrorReport::create([
            'worksheet_id' => $request->worksheet_id,
            'section_id' => $request->section_id,
            'user_id' => auth()->id(),
            'description' => $request->description,
        ]);

        // Notify admin (optional) and redirect back to the worksheet list
        return redirect()->route('worksheet.worksheet_list')->with('success', 'Error report submitted successfully!');
    }
}

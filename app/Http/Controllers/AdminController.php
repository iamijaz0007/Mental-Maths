<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ErrorReport;

class AdminController extends Controller
{
    public function assignChild(Request $request)
    {
        // Validate the request data
        $request->validate([
            'parent_id' => 'required|exists:users,id', // Ensure the parent exists
            'child_ids' => 'required|array',          // Ensure child IDs are provided in an array
            'child_ids.*' => 'exists:users,id',       // Ensure each child exists
        ]);

        // Loop through the selected children and assign them to the parent
        foreach ($request->child_ids as $child_id) {
            $child = User::find($child_id);
            $child->parent_id = $request->parent_id;  // Assign the parent_id to the child
            $child->save();                           // Save the child record with the updated parent_id
        }

        // Redirect back with a success message
        return redirect()->route('parent.list')->with('success', 'Children assigned to parent successfully.');
    }




        public function showAssignChildForm()
    {
        // Fetch all parents and students
        $parents = User::where('role', 4)->get();
        $students = User::where('role', 3)->get();

        return view('admin.assign_child', compact('parents', 'students'));
    }

    public function assignPrincipal(Request $request)
    {
        $request->validate([
            'principal_id' => 'required|exists:users,id',
            'school_id' => 'required|exists:schools,id',
        ]);

        // Find the current principal of the school, if any
        $existingPrincipal = User::where('school_id', $request->school_id)
                                ->where('role', 2)
                                ->first();

        // Unassign the current principal, if one exists
        if ($existingPrincipal) {
            $existingPrincipal->school_id = null;
            $existingPrincipal->save();
        }

        // Assign the new principal to the school
        $principal = User::find($request->principal_id);
        $principal->school_id = $request->school_id;
        $principal->save();

        return redirect()->route('principal.list')->with('success', 'Principal assigned to school successfully. Previous principal unassigned.');
    }



    public function showAssignPrincipalForm()
    {
        // Fetch all principals and schools
        $principals = User::where('role', 2)->get();
        $schools = School::all();

        return view('admin.assign_principal', compact('principals', 'schools'));
    }


// error report
    public function errorReports()
    {
        $errorReports = ErrorReport::with(['student', 'worksheet'])->get(); // Eager load student and worksheet

        return view('admin.error_reports', compact('errorReports'));
    }


    public function notAnErrorReport($id)
    {
        $report = ErrorReport::findOrFail($id);
        $report->update(['status' => 'not_an_error']);

        return redirect()->route('admin.error_reports')->with('success', 'Marked as not an error.');
    }



    public function showResolveForm($id)
    {
        $report = ErrorReport::findOrFail($id);
        return view('admin.resolve_report', compact('report'));
    }

    // Handle the form submission to resolve the error report
    public function submitResolution(Request $request, $id)
    {
        $request->validate([
            'admin_response' => 'required|string|max:1000',
        ]);

        $report = ErrorReport::findOrFail($id);
        $report->update([
            'status' => 'resolved',
            'admin_response' => $request->input('admin_response'),
        ]);

        return redirect()->route('admin.error_reports')->with('success', 'Error report resolved successfully.');
    }

}

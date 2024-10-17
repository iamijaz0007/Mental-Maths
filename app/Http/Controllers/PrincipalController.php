<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\School;
use App\Models\SectionProgress;
use App\Models\Worksheet;
use App\Models\StudentProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PrincipalController extends Controller
{
    public function index()
{
    $data['title'] = 'Principals List';

    // Fetch principals who are linked to schools
    $principalsWithSchools = DB::table('users')
        ->join('schools', 'users.school_id', '=', 'schools.id')
        ->where('users.role', 2)
        ->select(
            'users.id as principal_id',
            'users.name as principal_name',
            'users.email',
            'users.status as principal_status',
            'users.profile_pic',
            'schools.name as school_name',
            'schools.status as school_status'
        )
        ->paginate(10);

    // Fetch principals who are not linked to any school
    $principalsWithoutSchools = DB::table('users')
        ->leftJoin('schools', 'users.school_id', '=', 'schools.id')
        ->where('users.role', 2)
        ->whereNull('schools.id')
        ->select(
            'users.id as principal_id',
            'users.name as principal_name',
            'users.email',
            'users.status as principal_status',
            'users.profile_pic',
            'users.date_of_birth'
        )
        ->paginate(10);

    return view('principal.list', compact('data', 'principalsWithSchools', 'principalsWithoutSchools'));
}


    public function add()
    {
        $data['title'] = 'Add Principal';
        return view('principal.add', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'date_of_birth' => 'required|date|before:-30 years',
            'gender' => 'required|string|in:male,female,other'
        ]);

        $profilePicName = null;

        // Check if a profile picture is uploaded
        if ($request->hasFile('profile_pic')) {
            // Get the file from the request
            $profilePic = $request->file('profile_pic');

            // Define the directory and create it if it doesn't exist
            $destinationPath = public_path('/uploads/profile_pics');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Define a unique name for the file
            $profilePicName = time() . '_' . $profilePic->getClientOriginalName();

            // Move the file to the destination directory
            $profilePic->move($destinationPath, $profilePicName);
        }

        // Create new user
        $principal = new User();
        $principal->name = $request->name;
        $principal->email = $request->email;
        $principal->password = bcrypt($request->password); // Make sure to hash the password
        $principal->gender = $request->gender;
        $principal->date_of_birth = $request->date_of_birth;
        $principal->profile_pic = $profilePicName; // Save only the filename
        $principal->role = 2;
        $principal->save();

        return redirect()->route('principal.list')->with('success', 'Principal added successfully.');
    }


    public function edit($id)
    {
        $data['title'] = 'Edit Principal';
        $principal = User::findOrFail($id);
        return view('principal.edit', compact('principal', 'data'));
    }

    public function update(Request $request, $id)
    {
        // Validate the input fields
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'profile_pic' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'date_of_birth' => 'required|date|before:-30 years',
            'gender' => 'required|string|in:male,female,other',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Fetch the principal's data from the User model
        $principal = User::findOrFail($id);

        // Handle profile picture upload
        if ($request->hasFile('profile_pic')) {
            // If there is an existing profile picture, delete it
            if ($principal->profile_pic && file_exists(public_path('/uploads/profile_pics/' . $principal->profile_pic))) {
                unlink(public_path('/uploads/profile_pics/' . $principal->profile_pic));
            }

            // Get the file from the request
            $profilePic = $request->file('profile_pic');

            // Define the directory and create it if it doesn't exist
            $destinationPath = public_path('/uploads/profile_pics');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Define a unique name for the file
            $profilePicName = time() . '_' . $profilePic->getClientOriginalName();

            // Move the file to the destination directory
            $profilePic->move($destinationPath, $profilePicName);

            // Update the principal's profile_pic with the new image filename
            $principal->profile_pic = $profilePicName;
        }

        // Update the principal's details
        $principal->update([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
        ]);

        // Check if the password is filled, and update it
        if ($request->filled('password')) {
            $principal->password = bcrypt($request->password); // Hash the password before saving
            $principal->save(); // Save the model with the updated password
        }

        // Redirect with a success message
        return redirect()->route('principal.list')->with('success', 'Principal updated successfully.');
    }



    public function delete($id)
    {
        // Fetch the principal from the database
        $principal = User::findOrFail($id);

        // Check if the principal has a profile picture and delete it from the filesystem
        if ($principal->profile_pic && file_exists(public_path('/uploads/profile_pics/' . $principal->profile_pic))) {
            unlink(public_path('/uploads/profile_pics/' . $principal->profile_pic));
        }

        // Delete the principal record from the database
        $principal->delete();

        // Redirect with a success message
        return redirect()->route('principal.list')->with('success', 'Principal deleted successfully.');
    }


    public function listSchoolParents()
    {
        // Get the authenticated principal
        $principal = Auth::user();

        // Fetch parents whose children (students) are in the principal's school
        $parents = User::where('role', 4)
            ->whereHas('children', function ($query) use ($principal) {
                $query->where('school_id', $principal->school->id); // Only include students in the same school
            })
            ->with(['children' => function ($query) use ($principal) {
                $query->where('school_id', $principal->school->id); // Only include students in the same school
            }])
            ->paginate(10);

        return view('principal.parents_list', compact('parents'));
    }





    public function viewStudentProgress()
    {
        $schoolId = Auth::user()->school_id; // Get the principal's school ID
        $students = User::where('role', 3)->where('school_id', $schoolId)->get(); // Fetch students in the school

        return view('principal.student_progress', compact('students'));
    }

    public function showStudentProgress($studentId)
    {
        // Ensure the principal is authenticated
        $principal = Auth::user();

        // Fetch the student's data by ID, throw 404 if not found
        $student = User::findOrFail($studentId);

        // Fetch the student's progress from the student_progress table with associated worksheet and section progress
        $studentProgress = StudentProgress::where('user_id', $student->id)
            ->with([
                'worksheet.sections.sectionProgress' => function ($progressQuery) use ($student) {
                    $progressQuery->where('user_id', $student->id);
                },
                'worksheet.questions' // Ensure questions are eager loaded
            ])
            ->get();

        // Prepare the worksheet progress for the view
        $worksheetProgress = [];
        foreach ($studentProgress as $progress) {
            $sectionsData = [];

            foreach ($progress->worksheet->sections as $section) {
                $sectionProgress = $section->sectionProgress->first();

                // Add section data with time spent
                $sectionsData[] = [
                    'section_name' => $section->subject ?? 'N/A', // Safeguard against missing subject
                    'time_spent' => $sectionProgress ? $sectionProgress->time_taken : 0 // Time spent on the section
                ];
            }

            // Count total questions for the worksheet
            $totalQuestions = $progress->worksheet->questions->count();
            $correctQuestions = $progress->correct_questions;
            $incorrectQuestions = $progress->incorrect_questions;

            // Calculate the percentage of correct answers
            $correctPercentage = $totalQuestions > 0 ? ($correctQuestions / $totalQuestions) * 100 : 0;

            // Determine the grade based on the percentage
            $grade = '';
            if ($correctPercentage >= 90) {
                $grade = 'A';
            } elseif ($correctPercentage >= 80) {
                $grade = 'B';
            } elseif ($correctPercentage >= 70) {
                $grade = 'C';
            } elseif ($correctPercentage >= 60) {
                $grade = 'D';
            } else {
                $grade = 'F';
            }

            // Add data to worksheet progress
            $worksheetProgress[] = [
                'worksheet_name' => $progress->worksheet->name ?? 'Unnamed Worksheet', // Safeguard for missing name
                'totalQuestions' => $totalQuestions,
                'correctQuestions' => $correctQuestions,
                'incorrectQuestions' => $incorrectQuestions,
                'totalSections' => $progress->total_sections,
                'completedSections' => $progress->completed_sections,
                'remainingSections' => $progress->total_sections - $progress->completed_sections,
                'totalTimeSpent' => $progress->total_time_spent_on_worksheets ?? 0, // Safeguard against null time
                'status' => ($progress->completed_sections == $progress->total_sections) ? 'Completed' : 'In Progress',
                'sections' => $sectionsData,
                'grade' => $grade
            ];
        }

        // Render the view with the student's progress data
        return view('principal.showStudent_progress', compact('worksheetProgress', 'student'));
    }





}

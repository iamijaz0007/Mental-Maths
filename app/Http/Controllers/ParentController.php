<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\SectionProgress;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Worksheet;
use App\Models\StudentProgress;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\ParentReportMail;

class ParentController extends Controller
{
    public function index()
    {
        $data['title'] = 'Parent List';

        // Fetch all parents with pagination
        $parents = User::where('role', 4)->paginate(10);

        // Fetch parents with assigned children
        $parentsWithChildren = User::where('role', 4)
            ->has('children') // Ensure that only parents with children are retrieved
            ->with(['children' => function($query) {
                $query->select('parent_id', 'name'); // Fetch child's name and parent_id only
            }])
            ->paginate(10);

        return view('parent.list', compact('data', 'parents', 'parentsWithChildren'));
    }



    public function add()
    {
        $data['title'] = 'Parent add';
        return view('parent.add', $data);
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Parent';
        $parent = User::findOrFail($id);
        $data['parent'] = $parent;
        return view('parent.edit', $data);
    }

    public function create(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'gender' => 'required|in:male,female,other',
            'phone' => 'required|digits:11|unique:users,phone',
            'occupation' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:-30 years',
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $profilePicName = null;

        // Handle file upload using move() method
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $destinationPath = public_path('/uploads/profile_pics'); // Define custom path to store the image
            $profilePicName = time() . '.' . $file->getClientOriginalExtension(); // Create a unique name for the file

            // Move the file to the destination path
            $file->move($destinationPath, $profilePicName);
        }

        // Save the parent data
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); // Hash the password before saving
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->occupation = $request->occupation;
        $user->date_of_birth = $request->date_of_birth;
        $user->profile_pic = $profilePicName; // Save the image filename
        $user->role = 4;
        $user->save();

        // Redirect to the parent list with a success message
        return redirect()->route('parent.list')->with('success', 'Parent added successfully.');
    }


    public function update(Request $request, $id)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'gender' => 'required|in:male,female,other',
            'phone' => 'required|digits:11',
            'occupation' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:-30 years',
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Find the parent by ID
        $parent = User::findOrFail($id);

        // Handle file upload using move() method
        if ($request->hasFile('profile_pic')) {
            // Delete the old profile picture if it exists
            if ($parent->profile_pic) {
                $oldImagePath = public_path('/uploads/profile_pics/' . $parent->profile_pic);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Delete the old image from the file system
                }
            }

            $file = $request->file('profile_pic');
            $destinationPath = public_path('/uploads/profile_pics');
            $profilePicName = time() . '.' . $file->getClientOriginalExtension();

            // Move the file to the destination path
            $file->move($destinationPath, $profilePicName);
            $parent->profile_pic = $profilePicName; // Save the new image filename
        }

        // Update parent data
        $parent->name = $request->name;
        $parent->email = $request->email;
        $parent->gender = $request->gender;
        $parent->phone = $request->phone;
        $parent->occupation = $request->occupation;
        $parent->date_of_birth = $request->date_of_birth;

        // Only update the password if it was filled in
        if ($request->filled('password')) {
            $parent->password = bcrypt($request->password);
        }

        // Save the updated parent data
        $parent->save();

        // Redirect to the parent list with a success message
        return redirect()->route('parent.list')->with('success', 'Parent updated successfully.');
    }



    public function delete($id)
    {
        $parent = User::findOrFail($id);

        // Delete the profile picture from the file system
        if ($parent->profile_pic) {
            $imagePath = public_path('/uploads/profile_pics/' . $parent->profile_pic);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete the parent record
        $parent->delete();

        return redirect()->route('parent.list')->with('success', 'Parent deleted successfully.');
    }


    public function viewChildProgress($studentId)
    {
        // Retrieve the student's worksheets progress
        $worksheets = DB::table('quiz_attempts')
                        ->where('user_id', $studentId)
                        ->get();

        $student = User::find($studentId);

        // Pass the data to the view
        return view('parent.child_progress', compact('worksheets', 'student'));
    }

    public function listStudents()
    {
        // If the user is an admin, fetch all students
        if (Auth::user()->role == 1) {
            $students = User::where('role', 'student')->get();
        } elseif (Auth::user()->role == 4) { // If the user is a parent
            // Fetch the child associated with the parent
            $students = User::where('id', Auth::user()->child_id)->get();
        } else {
            // Return an empty collection for other roles
            $students = collect();
        }

        return view('parent.student_list', compact('students'));
    }

    public function showChildProgress($childId)
    {
        // Ensure the parent is authenticated
        $parent = Auth::user();

        // Ensure the parent only sees their own child's data
        $child = User::where('parent_id', $parent->id)->where('id', $childId)->firstOrFail();

        // Fetch the child's progress from the student_progress table with worksheet and sections
        $studentProgress = StudentProgress::where('user_id', $child->id)
            ->with(['worksheet.sections' => function ($query) use ($child) {
                $query->with(['sectionProgress' => function ($progressQuery) use ($child) {
                    // Fetch the progress for the specific child
                    $progressQuery->where('user_id', $child->id);
                }]);
            }])
            ->get();

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
                'grade' => $grade // Add grade to the data
            ];
        }

        return view('parent.child_progress', compact('worksheetProgress', 'child'));
    }



}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Worksheet;

class StudentController extends Controller
{
    public function index()
    {
        $authUser = auth()->user();
        if ($authUser->role == 1)
        {
            $students = User::where('role', 3)
            ->with('school')
            ->paginate(10);
        }
        elseif ($authUser->role == 2)
        {
            $students = User::where('role', 3)
            ->where('school_id', $authUser->school_id)
            ->with('school')
            ->paginate(10); } else {
            return redirect()->back()->with('error', 'User not authorized to view students.');
        }
        return view('student.list', compact('students'));
    }

    public function add(){
        $data['title'] ='Student add';
        return view('student.add', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'gender' => 'required|string|in:male,female',
            'date_of_birth' => 'required|date|before:-6 years',
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $principal = auth()->user();

        // Check if the principal is authenticated and has a school_id
        if (!$principal || !$principal->school_id) {
            return redirect()->back()->with('error', 'Principal is not associated with any school.');
        }

        $profilePicName = null;
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $destinationPath = public_path('/uploads/profile_pics'); // Define custom path
            $profilePicName = time() . '.' . $file->getClientOriginalExtension(); // Create unique filename
            $file->move($destinationPath, $profilePicName); // Move file to the destination
        }

        // Create a new student record
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']), // Hash the password
            'gender' => $request['gender'],
            'date_of_birth' => $request['date_of_birth'],
            'profile_pic' => $profilePicName, // Save the filename of the profile picture
            'role' => 3, // Assuming '3' is the role for students
            'school_id' => $principal->school_id,
        ]);

        return redirect()->route('student.list')->with('success', 'Student added successfully.');
    }



    public function edit($id)
    {
        $student = User::findOrFail($id);
        return view('student.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $student = User::findOrFail($id);

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $student->id,
            'password' => 'nullable|string|min:6|confirmed',
            'gender' => 'required|string|in:male,female',
            'date_of_birth' => 'required|date|before:-6 years',
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update the student data
        $student->name = $request->name;
        $student->email = $request->email;
        $student->gender = $request->gender;
        $student->date_of_birth = $request->date_of_birth;

        // Only update password if a new one is provided
        if ($request->filled('password')) {
            $student->password = bcrypt($request->password); // Hash the password
        }

        // Handle profile picture upload if a new one is provided
        if ($request->hasFile('profile_pic')) {
            // If there is an old profile picture, delete it
            if ($student->profile_pic) {
                $oldImagePath = public_path('/uploads/profile_pics/' . $student->profile_pic);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Delete the old image
                }
            }

            $file = $request->file('profile_pic');
            $destinationPath = public_path('/uploads/profile_pics');
            $profilePicName = time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $profilePicName); // Move file to the destination
            $student->profile_pic = $profilePicName;
        }

        $student->save();

        return redirect()->route('student.list')->with('success', 'Student updated successfully.');
    }



    public function delete($id)
    {
        $student = User::findOrFail($id);

        // If the student has a profile picture, delete it from storage
        if ($student->profile_pic) {
            $imagePath = public_path('/uploads/profile_pics/' . $student->profile_pic);
            if (file_exists($imagePath)) {
                unlink($imagePath); // Delete the image
            }
        }

        $student->delete();

        return redirect()->route('student.list')->with('success', 'Student deleted successfully.');
    }





}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
   // Display the profile edit form
   public function edit()
   {
       // Fetch the currently authenticated user
       $user = Auth::user();

       // Pass the user data to the view
       return view('profile.edit', compact('user'));
   }

   // Handle profile updates
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate the input fields
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id, // unique email validation except the current user
            'password' => 'nullable|min:6|confirmed', // password confirmation required if changing password
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // validation for profile picture
        ]);

        // Update the user's basic info
        $user->name = $request->name;
        $user->email = $request->email;

        // If a new password is provided, update the password
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        // If a new profile picture is uploaded, process the image upload using the `move()` method
        if ($request->hasFile('profile_pic')) {
            // Delete the old profile picture if it exists
            if ($user->profile_pic && file_exists(public_path('/uploads/profile_pics/' . $user->profile_pic))) {
                unlink(public_path('/uploads/profile_pics/' . $user->profile_pic));
            }

            // Get the uploaded file
            $file = $request->file('profile_pic');
            // Define the destination path and unique file name
            $destinationPath = public_path('/uploads/profile_pics');
            $profilePicName = time() . '.' . $file->getClientOriginalExtension(); // Create unique filename
            $file->move($destinationPath, $profilePicName); // Move the file to the destination

            // Update the profile picture path in the user's record
            $user->profile_pic = $profilePicName;
        }

        // Save the updated user data
        $user->save();

        // Redirect back with a success message
        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }

}

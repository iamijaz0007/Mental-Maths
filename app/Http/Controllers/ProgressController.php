<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudentWorksheetProgress;

class ProgressController extends Controller
{
    public function index()
    {
        // Fetch users with 'student' role and their progress
        $students = StudentWorksheetProgress::with('worksheet', 'user')
            ->whereHas('user', function ($query) {
                $query->where('role', 3);
            })
            ->get()
            ->groupBy('user_id');

        return view('student.worksheet_list', compact('students'));
    }
}

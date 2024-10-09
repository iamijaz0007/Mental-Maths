<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Worksheet;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Current authenticated user

        $data['title'] = 'Dashboard';

        // Role-based redirection with additional logic for parents
        switch ($user->role) {
            case 1: // Admin
                return view('admin.dashboard', $data);
            case 2: // Principal
                return view('principal.dashboard', $data);
            case 3: // Student
                return view('student.dashboard', $data);
            case 4: // Parent
                // Fetch the parent's child/children
                $children = User::where('parent_id', $user->id)->get();

                if ($children->isEmpty()) {
                    // Handle the case where no children are found
                    return view('parent.dashboard', $data)->with('error', 'No children found.');
                }

                // Pass the children to the dashboard view
                $data['children'] = $children;
                return view('parent.dashboard', $data);
            default:
                abort(403, 'Unauthorized action.');
        }
    }

}


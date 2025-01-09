<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the dashboard based on the user's role.
     */
    public function index()
    {
        $user = auth()->user(); // Get the authenticated user

        // Check the user's role and return the appropriate view
        switch ($user->role) {
            case 'admin':
                return view('dashboard.admin-dashboard');
            case 'student':
                return view('dashboard.student-dashboard');
            case 'faculty':
                return view('dashboard.faculty-dashboard');
            case 'program_chair':
                return view('dashboard.program-chair-dashboard');
            default:
                abort(403, 'Unauthorized'); // Handle unknown roles
        }
    }
}

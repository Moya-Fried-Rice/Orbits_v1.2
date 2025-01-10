<?php

use Illuminate\Support\Facades\Route;

// Route home direct to login
Route::get('/', function () {
    return redirect()->route('login');
});


// Route to course page
Route::get('/courses', function () {
    return view('courses.courses');
})
->middleware(['auth', 'check_role:admin'])  // Filter role: only admin
->name('courses');  // Route name


// Route to logs page
Route::get('/logs', function () {
    return view('logs.logs');
})
->middleware(['auth', 'check_role:admin']) // Filter role: only admin
->name('logs'); // Route name


// Route to dashboard with conditioning
Route::get('/dashboard', function () {
    $user = auth()->user();
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
            abort(403, 'Unauthorized');
    }
})
->middleware(['auth', 'check_role:admin,student,faculty,program_chair']) // Filter role: all
->name('dashboard'); // Route name
    

require __DIR__.'/auth.php';


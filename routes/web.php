<?php

use Illuminate\Support\Facades\Route;

// Route home direct to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route to course page
Route::get('/courses', function () {
    return view('courses.courses');
})->middleware(['auth', 'check_role:admin'])->name('courses');

// Route to department page
Route::get('/departments', function () {
    return view('departments.departments');
})->middleware(['auth', 'check_role:admin'])->name('departments');

// Route to logs page
Route::get('/logs', function () {
    return view('logs.logs');
})->middleware(['auth', 'check_role:admin'])->name('logs');

// Route to faculties page
Route::get('/faculties', function () {
    return view('faculties.faculties');
})->middleware(['auth', 'check_role:admin'])->name('faculties');

// Route to student page
Route::get('/students', function () {
    return view('students.students');
})->middleware(['auth', 'check_role:admin'])->name('students');

// Route to program page
Route::get('/programs', function () {
    return view('programs.programs');
})->middleware(['auth', 'check_role:admin'])->name('programs');

// Route to survey page
Route::get('/survey', function () {
    return view('survey.survey');
})->middleware(['auth', 'check_role:admin'])->name('survey');

// Route to section page
Route::get('/sections', function () {
    return view('sections.sections');
})->middleware(['auth', 'check_role:admin'])->name('sections');

// Route to accounts page
Route::get('/accounts', function () {
    return view('accounts.accounts');
})->middleware(['auth', 'check_role:admin'])->name('accounts');

// Route to accounts page
Route::get('/evaluation', function () {
    return view('evaluation.evaluation');
})->middleware(['auth', 'check_role:admin'])->name('evaluation');

// Route to results page
Route::get('/results', function () {
    return view('results.results');
})->middleware(['auth', 'check_role:admin'])->name('results');

// Route to monitor page
Route::get('/monitor', function () {
    return view('monitor.monitor');
})->middleware(['auth', 'check_role:admin'])->name('monitor');

// Route to ranking page
Route::get('/ranking', function () {
    return view('ranking.ranking');
})->middleware(['auth', 'check_role:admin'])->name('ranking');

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


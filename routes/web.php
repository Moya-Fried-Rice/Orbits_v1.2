<?php

use Illuminate\Support\Facades\Route;
use App\Models\Student;
use App\Models\Faculty;
use Illuminate\Support\Facades\Auth;

// Route home direct to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route to course page
Route::get('/courses', function () {
    return view('courses.courses');
})->middleware(['auth', 'check_role:4'])->name('courses');

// Route to department page
Route::get('/departments', function () {
    return view('departments.departments');
})->middleware(['auth', 'check_role:4'])->name('departments');

// Route to logs page
Route::get('/logs', function () {
    return view('logs.logs');
})->middleware(['auth', 'check_role:4'])->name('logs');

// Route to faculties page
Route::get('/faculties', function () {
    return view('faculties.faculties');
})->middleware(['auth', 'check_role:4'])->name('faculties');

    // Route to faculty profile
    Route::get('/faculty/{uuid}', function (string $uuid) {
        return view('faculties.faculty-profile', ['uuid' => $uuid]);
    })->middleware(['auth', 'check_role:4', 'verify_uuid:' . Faculty::class])->name('faculty.update');

// Route to student page
Route::get('/students', function () {
    return view('students.students');
})->middleware(['auth', 'check_role:4'])->name('students');

    // Route to student profile
    Route::get('/student/{uuid}', function (string $uuid) {
        return view('students.student-profile', ['uuid' => $uuid]);
    })->middleware(['auth', 'check_role:4', 'verify_uuid:' . Student::class])->name('student.update');

// Route to program page
Route::get('/programs', function () {
    return view('programs.programs');
})->middleware(['auth', 'check_role:4'])->name('programs');

// Route to survey page
Route::get('/survey', function () {
    return view('survey.survey');
})->middleware(['auth', 'check_role:4'])->name('survey');

// Route to section page
Route::get('/sections', function () {
    return view('sections.sections');
})->middleware(['auth', 'check_role:4'])->name('sections');

// Route to accounts page
Route::get('/accounts', function () {
    return view('accounts.accounts');
})->middleware(['auth', 'check_role:4'])->name('accounts');

// Route to accounts page
Route::get('/evaluation', function () {
    return view('evaluation.evaluation');
})->middleware(['auth', 'check_role:4'])->name('evaluation');

// Route to results page
Route::get('/results', function () {
    return view('results.results');
})->middleware(['auth', 'check_role:4'])->name('results');

// Route to monitor page
Route::get('/monitor', function () {
    return view('monitor.monitor');
})->middleware(['auth', 'check_role:4'])->name('monitor');

// Route to ranking page
Route::get('/ranking', function () {
    return view('ranking.ranking');
})->middleware(['auth', 'check_role:4'])->name('ranking');

// Route to dashboard with conditioning
Route::get('/dashboard', function () {
    $user = Auth::user();
    switch ($user->role_id) {
        case '4':
            return view('dashboard.admin-dashboard');
        case '1':
            return view('dashboard.student-dashboard');
        case '2':
            return view('dashboard.faculty-dashboard');
        case '3':
            return view('dashboard.program-chair-dashboard');
        default:
            abort(403, 'Unauthorized');
    }
})
->middleware(['auth', 'check_role:4,1,2,3']) // Filter role: all
->name('dashboard'); // Route name
    

require __DIR__.'/auth.php';


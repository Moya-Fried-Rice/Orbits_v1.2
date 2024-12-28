<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Accounts route
Route::get('/accounts', function () {
    return view('accounts.accounts');
})->name('accounts');

// Courses route
Route::get('/courses', function () {
    return view('courses.courses');
})->name('courses');

// Departments route
Route::get('/departments', function () {
    return view('departments.departments');
})->name('departments');

// Evaluation route
Route::get('/evaluation', function () {
    return view('evaluation.evaluation');
})->name('evaluation');

// Faculties route
Route::get('/faculties', function () {
    return view('faculties.faculties');
})->name('faculties');

// Monitor route
Route::get('/monitor', function () {
    return view('monitor.monitor');
})->name('monitor');

// Programs route
Route::get('/programs', function () {
    return view('programs.programs');
})->name('programs');

// Ranking route
Route::get('/ranking', function () {
    return view('ranking.ranking');
})->name('ranking');

// Results route
Route::get('/results', function () {
    return view('results.results');
})->name('results');

// Sections route
Route::get('/sections', function () {
    return view('sections.sections');
})->name('sections');

// Students route
Route::get('/students', function () {
    return view('students.students');
})->name('students');

// Survey route
Route::get('/survey', function () {
    return view('survey.survey');
})->name('survey');

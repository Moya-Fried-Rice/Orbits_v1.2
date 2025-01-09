<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LogController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/courses', [CourseController::class, 'index'])
    ->middleware(['auth', 'check_role:admin'])
    ->name('courses');

Route::get('/logs', [LogController::class, 'index'])
    ->middleware(['auth', 'check_role:admin'])
    ->name('logs');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'check_role:admin,student,faculty,program_chair'])
    ->name('dashboard');


require __DIR__.'/auth.php';


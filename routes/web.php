<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LogController;

// Home route
Route::get('/', function () {
    return view('auth.login');
});

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('courses', CourseController::class);
Route::resource('logs', LogController::class);
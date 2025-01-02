<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('courses', CourseController::class);
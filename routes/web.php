<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LogController;


Route::get('/', function () {
    return view('auth.login');
});

Route::resource('courses', CourseController::class);
Route::resource('logs', LogController::class);

Route::get('/dashboard', function () {
    return view('dashboard.admin_dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__.'/auth.php';



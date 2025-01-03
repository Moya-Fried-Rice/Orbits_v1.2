<?php

namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // Show all courses
    public function index(Request $request)
    {
       
        return view('courses.courses');
    }

}

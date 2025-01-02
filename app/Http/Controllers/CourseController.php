<?php

namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // Show all courses
    public function index()
    {
        $courses = Course::all();
        return view('courses.courses', compact('courses'));
    }

    // Show the form to create a new course
    public function create()
    {
        $departments = Department::all();
        return view('courses.course-create', compact('departments'));
    }

    // Store a new course
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'course_description' => 'nullable|string|max:220',
            'course_code' => 'nullable|string|max:220',
            'department_id' => 'nullable|integer',
        ]);

        Course::create($validated);

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    // Show a single course
    public function show($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.show', compact('course'));
    }

    // Show the form to edit a course
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $departments = Department::all();
        return view('courses.course-edit', compact('course', 'departments'));
    }


    // Update a course
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'course_description' => 'nullable|string|max:220',
            'course_code' => 'nullable|string|max:220',
            'department_id' => 'nullable|integer',
        ]);

        $course = Course::findOrFail($id);
        $course->update($validated);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    // Delete a course
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}

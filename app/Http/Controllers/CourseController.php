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
        $sortBy = $request->input('sort_by', 'created_at'); // Default to 'course_code'
        $sortOrder = $request->input('sort_order', 'asc'); // Default to ascending order
        $searchName = $request->input('search_name');
        $searchCode = $request->input('search_code');
        $departmentId = $request->input('department_id');
        
        // Fetch courses based on the search criteria
        $courses = Course::query();
        
        if ($searchName) {
            $courses = $courses->where('course_name', 'like', '%' . $searchName . '%');
        }
        
        if ($searchCode) {
            $courses = $courses->where('course_code', 'like', '%' . $searchCode . '%');
        }
        
        if ($departmentId) {
            $courses = $courses->where('department_id', $departmentId);
        }
        
        if ($sortBy == 'department_code') {
            $courses = $courses->join('departments', 'departments.department_id', '=', 'courses.department_id')
                            ->orderBy('departments.department_code', $sortOrder);
        } elseif ($sortBy == 'department_name') {
            $courses = $courses->join('departments', 'departments.department_id', '=', 'courses.department_id')
                            ->orderBy('departments.department_name', $sortOrder);
        } else {
            $courses = $courses->orderBy($sortBy, $sortOrder);
        }
        
        // Paginate the courses
        $courses = $courses->paginate(10);
        
        // Get all departments for the filter dropdown
        $departments = Department::all();
        
        // Pass the selected department (departmentId) to the view
        return view('courses.courses', compact('courses', 'departments', 'searchName', 'searchCode', 'departmentId', 'sortBy', 'sortOrder'));
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

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;  // Changed to Course model

class SearchCourses extends Component
{
    public $searchCourse = '';  // Holds the search input
    public $courses = [];       // Holds the filtered courses

    // Listen for the clearFilters event
    protected $listeners = ['clearFilters' => 'clearFilters']; 

    // This method will clear the search term
    public function clearFilters()
    {
        $this->searchCourse = '';
        $this->courses = Course::all();  // Fetch all courses
    }

    // This method is called whenever the searchCourse property is updated
    public function updatedSearchCourse()
    {
        if (empty($this->searchCourse)) {
            // If the search input is empty, get all courses
            $this->courses = Course::all();
        } else {
            // Filter courses based on the search input
            $this->courses = Course::where('course_code', 'like', '%' . $this->searchCourse . '%')
                ->orWhere('course_name', 'like', '%' . $this->searchCourse . '%')
                ->get();
        }
    }

    // This method is called when a course is selected
    public function selectCourse($courseId)
    {
        // Find the course by its ID
        $course = Course::find($courseId);

        if ($course) {
            // Update the input field with the selected course's code
            $this->searchCourse = $course->course_code;

            // Optionally, clear the dropdown list
            $this->courses = [];

            // Dispatch an event with the selected course's ID
            $this->dispatch('courseSelected', $course->course_id);
        }
    }

    // Render the Livewire component view
    public function render()
    {
        return view('livewire.search-courses');  // Changed view name to match courses
    }
}

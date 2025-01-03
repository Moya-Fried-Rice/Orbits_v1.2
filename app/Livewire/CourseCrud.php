<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Department;
use Livewire\WithPagination;

class CourseCrud extends Component
{
    use WithPagination;

    public $text;

    public $course_id, $course_name, $course_description, $course_code, $department_id;
    public $updateMode = false;
    public $search = '';
    public $departmentFilter = '';

    protected $rules = [
        'course_name' => 'required|string|max:255',
        'course_code' => 'required|string|max:50',
        'course_description' => 'nullable|string|max:500',
        'department_id' => 'required|exists:departments,department_id',
    ];

    public function render()
    {
        $courses = Course::where('course_name', 'like', '%' . $this->search . '%')
                        ->orWhere('course_code', 'like', '%' . $this->search . '%')
                        ->when($this->departmentFilter, function ($query) {
                            return $query->where('department_id', $this->departmentFilter);
                        })
                        ->paginate(10);

        return view('livewire.course-crud', [
            'courses' => $courses,
            'departments' => Department::all()
        ]);
    }

    public function store()
    {
        $this->validate();

        Course::create([
            'course_name' => $this->course_name,
            'course_description' => $this->course_description,
            'course_code' => $this->course_code,
            'department_id' => $this->department_id
        ]);

        session()->flash('message', 'Course successfully added!');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $this->course_id = $course->course_id;
        $this->course_name = $course->course_name;
        $this->course_description = $course->course_description;
        $this->course_code = $course->course_code;
        $this->department_id = $course->department_id;

        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate();

        $course = Course::find($this->course_id);
        $course->update([
            'course_name' => $this->course_name,
            'course_description' => $this->course_description,
            'course_code' => $this->course_code,
            'department_id' => $this->department_id
        ]);

        session()->flash('message', 'Course successfully updated!');
        $this->resetInputFields();
        $this->updateMode = false;
    }

    public function delete($id)
    {
        Course::find($id)->delete();
        session()->flash('message', 'Course successfully deleted!');
    }

    public function resetInputFields()
    {
        $this->course_id = null;
        $this->course_name = '';
        $this->course_description = '';
        $this->course_code = '';
        $this->department_id = '';
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->departmentFilter = '';
    }

    public function getDepartments()
    {
        return Department::all();
    }

    // Add the search function triggered by button
    public function searchCourses()
    {
        // Trigger render with the current search value
        $this->resetPage(); // Reset pagination when a search is performed
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Department;
use Livewire\WithPagination;

class CourseCrud extends Component
{
    use WithPagination;

    // Public properties for the course CRUD operations and modal states.
    public $course_id, $course_name, $course_description, $course_code, $department_id;
    public $updateMode = false;
    public $showConfirmation = false;
    public $showDeleteConfirmation = false;
    public $search = '';
    public $deleteId;
    public $page = 1;
    public $sortField = 'created_at';
    public $sortDirection = 'asc';
    public $isFocused = false;
    public $searchDepartment = '';
    public $selectedDepartment = '';
    public $departments = [];

    // Validation rules for storing or updating courses.
    protected $rules = [
        'course_name' => 'required|string|max:255',
        'course_code' => 'required|string|max:50',
        'course_description' => 'nullable|string|max:500',
        'department_id' => 'required|exists:departments,department_id',
    ];

    // Fetch departments from the database
    public function mount()
    {
        $this->departments = Department::all();
    }

    // Render method to display the view with courses and departments.
    public function render()
    {
        $courses = Course::query()
            ->where(function($query) {
                $query->where('course_name', 'like', '%' . $this->search . '%')
                    ->orWhere('course_code', 'like', '%' . $this->search . '%');
            });

        if ($this->selectedDepartment) {
            $courses->where('department_id', $this->selectedDepartment);
        }

        $courses = $courses->orderBy($this->sortField, $this->sortDirection)
            ->paginate(12);

        return view('livewire.course-crud', compact('courses'));
    }

    // Store method to add a new course.
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
        $this->showConfirmation = false;
    }

    // Edit method to populate fields when editing an existing course.
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $this->course_id = $course->course_id;
        $this->course_name = $course->course_name;
        $this->course_description = $course->course_description;
        $this->course_code = $course->course_code;
        $this->department_id = $course->department_id;

        $this->showConfirmation = true;
        $this->updateMode = true;
    }

    // Update method to save changes when updating an existing course.
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
        $this->showConfirmation = false;
    }

    // Delete method to trigger the deletion confirmation modal.
    public function delete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteConfirmation = true;
    }

    // Confirm delete method to delete the course if confirmed.
    public function confirmDelete()
    {
        if ($this->deleteId) {
            Course::find($this->deleteId)->delete();
            session()->flash('message', 'Course successfully deleted!');
            $this->showDeleteConfirmation = false;
            $this->deleteId = null;
        }
    }

    // Cancel delete method to close the delete confirmation modal without deleting.
    public function cancelDelete()
    {
        $this->showDeleteConfirmation = false;
        $this->deleteId = null;
    }

    // Reset input fields after adding or editing a course.
    public function resetInputFields()
    {
        $this->course_id = null;
        $this->course_name = '';
        $this->course_description = '';
        $this->course_code = '';
        $this->department_id = '';
    }

    // Method to fetch all departments (called for dropdown).
    public function getDepartments()
    {
        return Department::all();
    }

    // Show the modal for adding a new course.
    public function showAddCourseModal()
    {
        $this->resetInputFields();
        $this->showConfirmation = true;
        $this->updateMode = false;
    }

    // Method to handle department selection
    public function selectDepartment($departmentId)
    {
        $this->selectedDepartment = $departmentId;
        $this->searchDepartment = '';
    }

    // Triggered when the filter button is clicked
    public function applyFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function showDropdown($status)
    {
        $this->isFocused = $status;
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedDepartment = '';
        $this->resetPage();
    }
}

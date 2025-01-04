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
    public $selectedDepartment = '';





    // Listen for events dispatched by other Livewire components. __________..
    protected $listeners = [
        'departmentSelected' => 'departmentSearch',
        'searchPerformed' => 'searchCourses'
    ];
    //______________________________________________________________________..





    // Method to search courses by name or code. ____________________________..
    public function searchCourses($searchTerm)
    {
        $this->search = $searchTerm;
        $this->resetPage();
    }
    //_______________________________________________________________________..





    // Method to filter courses by department. _____________________________..
    public function departmentSearch($departmentId)
    {
        $this->selectedDepartment = $departmentId;
        $this->resetPage();
    }
    //______________________________________________________________________..




    
    // Validation rules for storing or updating courses. ____________________..
    protected $rules = [
        'course_name' => 'required|string|max:255',
        'course_code' => 'required|string|max:50',
        'course_description' => 'nullable|string|max:500',
        'department_id' => 'required|exists:departments,department_id',
    ];
    //______________________________________________________________________..




    // Render method to display the view with courses and departments. ______..
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
        $courses = $courses->orderBy($this->sortField, $this->sortDirection)->paginate(12);
        return view('livewire.course-crud', compact('courses'));
    }
    //______________________________________________________________________..





    // Store method to add a new course. __________________________________..
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
    //______________________________________________________________________..





    // Populate fields when editing an existing course. ____________________..
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
    //______________________________________________________________________..





    // Save changes when updating an existing course. _______________________..
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
    //______________________________________________________________________..





    // Trigger the deletion confirmation modal. ____________________________..
    public function delete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteConfirmation = true;
    }
    //______________________________________________________________________..





    // Method to delete the course if confirmed. ___________________________..
    public function confirmDelete()
    {
        if ($this->deleteId) {
            Course::find($this->deleteId)->delete();
            session()->flash('message', 'Course successfully deleted!');
            $this->showDeleteConfirmation = false;
            $this->deleteId = null;
        }
    }
    //______________________________________________________________________..





    // Close the delete confirmation modal without deleting. ________________..
    public function cancelDelete()
    {
        $this->showDeleteConfirmation = false;
        $this->deleteId = null;
    }
    //______________________________________________________________________..





    // Reset input fields after adding or editing a course. ________________..
    public function resetInputFields()
    {
        $this->course_id = null;
        $this->course_name = '';
        $this->course_description = '';
        $this->course_code = '';
        $this->department_id = '';
    }
    //______________________________________________________________________..





    // Show the modal for adding a new course. _____________________________..
    public function showAddCourseModal()
    {
        $this->resetInputFields();
        $this->showConfirmation = true;
        $this->updateMode = false;
    }
    //______________________________________________________________________..





    // Sort courses by field and direction. ________________________________..
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    //______________________________________________________________________..





    // Clear search filters. _______________________________________________..
    public function clearFilters()
    {
        $this->search = '';
        $this->selectedDepartment = '';
        $this->resetPage();
    }
    //______________________________________________________________________..



    // Method to get all departments for the dropdown. ______________________..
    public function getDepartments()
    {
        return Department::all();
    }
    //______________________________________________________________________..

}

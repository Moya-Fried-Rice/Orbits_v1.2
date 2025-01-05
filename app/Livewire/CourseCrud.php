<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Department;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class CourseCrud extends Component
{
    use WithPagination;

    // Public properties for course data and modal states.
    public $course_id, $course_name, $course_description, $course_code, $department_id;
    public $updateMode = false, $showConfirmation = false, $showDeleteConfirmation = false;
    public $search = '', $deleteId, $selectedDepartment = '';
    public $sortField = 'created_at', $sortDirection = 'asc';

    // Listen to dispatched events
    protected $listeners = [
        'departmentSelected' => 'departmentSearch',
        'searchPerformed' => 'searchCourses'
    ];

    // Validation rules
    protected $rules = [
        'course_name' => 'required|string|max:255',
        'course_code' => 'required|string|max:50',
        'course_description' => 'nullable|string|max:500',
        'department_id' => 'required|exists:departments,department_id',
    ];

    // Search courses
    public function searchCourses($searchTerm)
    {
        $this->search = $searchTerm;
        $this->resetPage();
    }

    // Filter courses by department
    public function departmentSearch($departmentId)
    {
        $this->selectedDepartment = $departmentId;
        $this->resetPage();
    }

    // Store method to add a new course
    public function store()
    {
        $this->validate();
        
        try {
            Course::create([
                'course_name' => $this->course_name,
                'course_description' => $this->course_description,
                'course_code' => $this->course_code,
                'department_id' => $this->department_id,
            ]);
            session()->flash('success', 'Course successfully added!');
        } catch (Exception $e) {
            session()->flash('error', 'Failed to add course: ' . $e->getMessage());
        } finally {
            $this->resetInputFields();
            $this->showConfirmation = false;
        }
    }

    // Edit course details
    public function edit($id)
    {
        try {
            $course = Course::findOrFail($id);
            $this->course_id = $course->course_id;
            $this->course_name = $course->course_name;
            $this->course_description = $course->course_description;
            $this->course_code = $course->course_code;
            $this->department_id = $course->department_id;
            $this->updateMode = true;
            $this->showConfirmation = true;
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Course not found.');
        } catch (Exception $e) {
            session()->flash('error', 'Failed to load course: ' . $e->getMessage());
        }
    }

    // Update method for modifying course details
    public function update()
    {
        $this->validate();
        
        try {
            $course = Course::findOrFail($this->course_id);
            $course->update([
                'course_name' => $this->course_name,
                'course_description' => $this->course_description,
                'course_code' => $this->course_code,
                'department_id' => $this->department_id,
            ]);
            session()->flash('success', 'Course successfully updated!');
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Course not found.');
        } catch (Exception $e) {
            session()->flash('error', 'Failed to update course: ' . $e->getMessage());
        } finally {
            $this->resetInputFields();
            $this->updateMode = false;
            $this->showConfirmation = false;
        }
    }

    // Delete method to initiate course deletion
    public function delete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteConfirmation = true;
    }

    // Confirm deletion of a course
    public function confirmDelete()
    {
        if ($this->deleteId) {
            try {
                $course = Course::findOrFail($this->deleteId);

                // Check for related course sections
                if ($course->courseSections()->exists()) {
                    session()->flash('error', 'Cannot delete the course due to related course sections.');
                    $this->resetDeleteState();
                    return;
                }

                $course->delete();
                session()->flash('success', 'Course successfully deleted!');
            } catch (ModelNotFoundException $e) {
                session()->flash('error', 'Course not found.');
            } catch (Exception $e) {
                session()->flash('error', 'Failed to delete course: ' . $e->getMessage());
            } finally {
                $this->resetDeleteState();
            }
        }
    }

    // Reset delete state
    private function resetDeleteState()
    {
        $this->showDeleteConfirmation = false;
        $this->deleteId = null;
    }

    // Close delete confirmation modal without deleting
    public function cancelDelete()
    {
        $this->showDeleteConfirmation = false;
        $this->deleteId = null;
    }

    // Reset all input fields
    private function resetInputFields()
    {
        $this->reset(['course_id', 'course_name', 'course_code', 'course_description', 'department_id']);
    }

    // Open modal for adding a new course
    public function showModal()
    {
        $this->resetInputFields();
        $this->showConfirmation = true;
        $this->updateMode = false;
    }

    // Close modal when canceled or closed
    public function closeModal() {
        $this->resetInputFields();
        $this->showConfirmation = false;
        $this->resetErrorBag();
    }

    // Sort courses by field and direction
    public function sortBy($field)
    {
        $this->sortField = $this->sortField === $field ? $this->sortField : $field;
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    // Clear filters
    public function clearFilters()
    {
        $this->search = '';
        $this->selectedDepartment = '';
        $this->resetPage();
        $this->dispatch('clearFilters');
    }

    // Fetch all departments for dropdown
    public function getDepartments()
    {
        return Department::all();
    }

    // Clear session messages
    public function clearMessage()
    {
        session()->forget(['success', 'error']);
    }

    // Render method for displaying courses and departments
    public function render()
    {
        $courses = Course::query()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('course_name', 'like', '%' . $this->search . '%')
                        ->orWhere('course_code', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedDepartment, fn($query) => $query->where('department_id', $this->selectedDepartment))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(12);

        return view('livewire.course-crud', compact('courses'));
    }

}

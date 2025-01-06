<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Department;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Livewire\WithPagination;
use Exception;

class CourseCrud extends Component
{
    use WithPagination;

    // Public properties for course data and modal states.
    public $course_id, $course_name, $course_description, $course_code, $department_id;
    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;
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
        session()->forget(['success', 'error', 'info']);
    }





    // Method for editing field ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓

        // Clicked edit to show forms > Show Confirmation > Confirm/Cancel > Update and close everthing
        // Modal/s - showEditForm, showEditConfirmation
        
        // Step 1: Choose field to edit to show forms
        public function edit($id)
        {
            $this->resetErrorBag();
            try {
                $course = Course::findOrFail($id);
                $this->course_id = $course->course_id;
                $this->course_name = $course->course_name;
                $this->course_description = $course->course_description;
                $this->course_code = $course->course_code;
                $this->department_id = $course->department_id;
                $this->showEditForm = true;
            } catch (ModelNotFoundException $e) {
                session()->flash('error', 'Course not found.');
            } catch (Exception $e) {
                session()->flash('error', 'Failed to load course: ' . $e->getMessage());
            }
        }

        // Step 2: Show update confirmation
        public function updateConfirmation()
        {
            $this->validate();
            $this->showEditForm = false; // Close the forms
            $this->showEditConfirmation = true; // Show confirmation
        }

        // Step 3 Confirm/Cancel update

            // If confirmed
            public function confirmUpdate()
            {
                $this->update(); // Update the field
                $this->closeEdit();
            }

            // If canceled
            public function cancelUpdate()
            {
                $this->showEditConfirmation = false; // Close the confirmation modal
                $this->showEditForm = true; // Show the edit form again
                $this->resetErrorBag(); // Reset errors
            }

        // Step 4: Update the field
        public function update()
        {
            $this->validate();
            
            try {
                $course = Course::findOrFail($this->course_id);

                // Check if any fields have changed
                $changes = false;
                if ($course->course_name !== $this->course_name) {
                    $course->course_name = $this->course_name;
                    $changes = true;
                }
                if ($course->course_description !== $this->course_description) {
                    $course->course_description = $this->course_description;
                    $changes = true;
                }
                if ($course->course_code !== $this->course_code) {
                    $course->course_code = $this->course_code;
                    $changes = true;
                }
                if ($course->department_id !== $this->department_id) {
                    $course->department_id = $this->department_id;
                    $changes = true;
                }

                // If there are changes, update the course
                if ($changes) {
                    $course->save();
                    session()->flash('success', 'Course successfully updated!');
                } else {
                    session()->flash('info', 'No changes were made.');
                }
            } catch (ModelNotFoundException $e) {
                session()->flash('error', 'Course not found.');
            } catch (Exception $e) {
                session()->flash('error', 'Failed to update course: ' . $e->getMessage());
            } finally {
                $this->closeEdit();
            }
        }


        // Close all
        public function closeEdit() {
            $this->showEditForm = false;
            $this->showEditConfirmation = false;
            $this->resetErrorBag();
        }

    // Method for editing field ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑





    // Method for deleting field ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓

        // Clicked delete to show confirmation > Confirm/Cancel > Delete and close everything
        // Modal/s - showDeleteConfirmation

        // Step 1: Choose field to delete
        public function delete($id)
        {
            $this->deleteId = $id;
            $this->showDeleteConfirmation = true;
        }

        // Step 2: Confirm/Cancel delete

            // If confirmed
            public function confirmDelete()
            {
                $this->remove(); // Delete a field from database
                $this->showDeleteConfirmation = false; // Close confirmation modal
                $this->deleteId = null; // Reset delete state
            }

            // If canceled
            public function cancelDelete()
            {
                $this->showDeleteConfirmation = false; // Close confirmation modal
                $this->deleteId = null; // Reset delete state
            }

        // Step 3: Delete a field
        private function remove()
        {
            if ($this->deleteId) {
                try {
                    $course = Course::findOrFail($this->deleteId);

                    // Check for related course sections
                    if ($course->courseSections()->exists()) {
                        session()->flash('error', 'Cannot delete the course due to related course sections.');
                        return;
                    }

                    $course->delete();
                    session()->flash('deleted', 'Course successfully deleted!');
                } catch (ModelNotFoundException $e) {
                    session()->flash('error', 'Course not found.');
                } catch (Exception $e) {
                    session()->flash('error', 'Failed to delete course: ' . $e->getMessage());
                }
            }
        }

        // Restore deleted field
        private function restore()
        {
            if ($this->deleteId) {
                try {
                    // Find the soft-deleted course by its ID
                    $course = Course::withTrashed()->findOrFail($this->deleteId);

                    // Check if the course is already restored
                    if (!$course->trashed()) {
                        session()->flash('info', 'Course is not deleted.');
                        return;
                    }

                    // Restore the course
                    $course->restore();

                    session()->flash('success', 'Course successfully restored!');
                } catch (ModelNotFoundException $e) {
                    session()->flash('error', 'Course not found.');
                } catch (Exception $e) {
                    session()->flash('error', 'Failed to restore course: ' . $e->getMessage());
                }
            }
        }

    // Method for deleting field ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑





    // Method for adding field ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓

        // Clicked add to show forms > Show add confirmation > Add/Cancel > Add and close everything
        // Modal/s - showAddForm

        // Step 1: Clicked add button
        public function add()
        {
            $this->resetErrorBag(); // Reset errors
            $this->resetInputFields(); // Reset inputs
            $this->showAddForm = true; // Show add form modal
        }

        // Step 2: Show confirmation
        public function storeConfirmation() 
        {
            $this->validate(); // Validate first
            $this->showAddForm = false; // Close add form modal
            $this->showAddConfirmation = true; // Show confirmation modal
        }


        // Step 3: Confirm/Cancel add

            // If confirmed
            public function confirmStore() {
                $this->store(); // Store new field
                $this->showAddConfirmation = false; // Close confirmation
                $this->showAddForm = false; // Close add form modal
                $this->resetInputFields(); // Reset inputs
            }

            // If canceled
            public function cancelStore() {
                $this->showAddConfirmation = false; // Close confirmation
                $this->showAddForm = true; // Show add form modal again
                $this->resetErrorBag();
            }

        // Step 4: Store new field
        public function store()
        {
            $this->validate();
        
            try {
                $course = Course::create([
                    'course_name' => $this->course_name,
                    'course_description' => $this->course_description,
                    'course_code' => $this->course_code,
                    'department_id' => $this->department_id,
                ]);
        
                // Log the activity
                activity()
                    ->performedOn($course)
                    ->causedBy(auth()->user())
                    ->withProperties([
                        'course_name' => $this->course_name,
                        'course_code' => $this->course_code,
                        'department_id' => $this->department_id,
                    ])
                    ->log('Course created');
        
                session()->flash('success', 'Course successfully added!');
            } catch (Exception $e) {
                session()->flash('error', 'Failed to add course: ' . $e->getMessage());
            } finally {
                $this->resetInputFields();
            }
        }
        
        // Reset all input fields
        private function resetInputFields()
        {
            $this->reset(['course_id', 'course_name', 'course_code', 'course_description', 'department_id']);
        }

        // Close all
        public function closeAdd() {
            $this->showAddForm = false; // Close add form modal
            $this->showAddConfirmation = false; // Close confirmation
            $this->resetInputFields(); // Reset inputs
            $this->resetErrorBag(); // Reset errors
        }

    // Method for adding field ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑





    // Render method for displaying courses and departments ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓

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

    // Render method for displaying courses and departments ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑




    // Testing lang to delete pag tapos
    public $logs = [];
    public $showLogs = false;

    public function toggleLogs()
    {
        $this->showLogs = !$this->showLogs;

        if ($this->showLogs) {
            $this->logs = Activity::latest()->get();
        } else {
            $this->logs = [];
        }
    }
}

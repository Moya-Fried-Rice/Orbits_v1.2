<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Department;
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
        session()->forget(['success', 'error', 'info', 'deleted']);
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
                $changes = $this->checkChanges($course);
                $this->handleUpdate($course, $changes);

            } catch (ModelNotFoundException $e) {
                $this->logError('Course not found', $e);
            } catch (Exception $e) {
                $this->logError('Failed to update course', $e);
            } finally {
                $this->closeEdit();
            }
        }

        // Handle field update
        private function handleUpdate($course, $changes)
        {
            if ($changes) {
                $course->save();
                $this->logUpdate($course);
            } else {
                $this->logNoChanges($course);
            }
        }

        // Log update
        private function logUpdate($course)
        {
            session()->flash('success', 'Course successfully updated!');
            activity()
                ->performedOn($course)
                ->causedBy(auth()->user())
                ->withProperties([
                    'type' => 'update',
                    'changes' => $this->changedProperties,
                    'course_id' => $course->course_id,
                ])
                ->log('Course updated');
        }

        // Log if no changes
        private function logNoChanges($course)
        {
            session()->flash('info', 'No changes were made.');
            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'type' => 'update',
                    'changes' => 'No changes were made',
                    'course_id' => $course->course_id])
                ->log('No changes made to course');
        }

        // Check for changes
        private function checkChanges($course)
        {
            $changes = false;
            $this->changedProperties = [];

            $properties = [
                'course_name' => $this->course_name,
                'course_description' => $this->course_description,
                'course_code' => $this->course_code,
                'department_id' => $this->department_id,
            ];

            foreach ($properties as $property => $newValue) {
                $oldValue = $course->$property;
                if ($oldValue !== $newValue) {
                    $course->$property = $newValue;
                    $changes = true;
                    $this->changedProperties[$property] = ['old' => $oldValue, 'new' => $newValue];
                }
            }

            return $changes;
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
        public function remove()
        {
            if ($this->deleteId) {
                try {
                    $course = Course::findOrFail($this->deleteId);
                    $this->checkForRelatedSections($course);
                } catch (ModelNotFoundException $e) {
                    $this->logError('Course not found', $e);
                } catch (Exception $e) {
                    $this->logError('Failed to delete course', $e);
                }
            }
        }

        // Check for constraints
        private function checkForRelatedSections($course)
        {
            if ($course->courseSections()->exists()) {
                $this->logError('Cannot delete the course due to related course sections.', null, $course);
                session()->flash('error', 'Cannot delete the course due to related course sections.');
                return;
            } else {
                $this->storeDeletedCourse($course);
                $this->deleteCourse($course);
            }
        }

        // Store deleted id in session
        private function storeDeletedCourse($course)
        {
            session()->put('deleted_course_id', $this->deleteId);
        }

        // Soft delete course
        private function deleteCourse($course)
        {
            $course->delete();
            session()->flash('deleted', 'Course successfully deleted!');
            $this->logDeletion($course);
        }

        // Log deletion
        private function logDeletion($course)
        {
            activity()
                ->performedOn($course)
                ->causedBy(auth()->user())
                ->withProperties([
                    'type' => 'delete',
                    'course_id' => $course->course_id,
                    'course_name' => $course->course_name,
                ])
                ->log('Course deleted');
        }

        // Step 4: Restore a deleted field
        public function undoDelete()
        {
            $courseId = session()->get('deleted_course_id');

            if ($courseId) {
                try {
                    $course = Course::withTrashed()->findOrFail($courseId);
                    $this->checkIfRestored($course);
                } catch (ModelNotFoundException $e) {
                    $this->logError('Course not found', $e, $courseId);
                } catch (Exception $e) {
                    $this->logError('Failed to restore course', $e);
                }
            }
        }

        // Check if already restored
        private function checkIfRestored($course)
        {
            if (!$course->trashed()) {
                $this->logError('Course is already active', null, $course->course_id);
                session()->flash('error', 'Course is already active.');
                return;
            } else {
                $this->restoreCourse($course);
            }
        }

        // Restore if not restored
        private function restoreCourse($course)
        {
            $course->restore();
            session()->forget('deleted_course_id');
            $this->logRestoration($course);
            session()->flash('success', 'Course successfully restored!');
        }

        // Log restoration
        private function logRestoration($course)
        {
            activity()
                ->performedOn($course)
                ->causedBy(auth()->user())
                ->withProperties([
                    'type' => 'restore',
                    'course_id' => $course->course_id,
                    'course_name' => $course->course_name,
                ])
                ->log('Course restored');
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
                $course = $this->createCourse();
                $this->logAdd('Course created', $course);
                session()->flash('success', 'Course successfully added!');
            } catch (Exception $e) {
                $this->logError('Failed to create course', $e);
                session()->flash('error', 'Failed to add course: ' . $e->getMessage());
            } finally {
                $this->resetInputFields();
            }
        }

        private function createCourse()
        {
            return Course::create([
                'course_name' => $this->course_name,
                'course_description' => $this->course_description,
                'course_code' => $this->course_code,
                'department_id' => $this->department_id,
            ]);
        }

        private function logAdd($message, $course)
        {
            activity()
                ->performedOn($course)
                ->causedBy(auth()->user())
                ->withProperties([
                    'type' => 'add',
                    'course_name' => $this->course_name,
                    'course_code' => $this->course_code,
                    'department_id' => $this->department_id,
                ])
                ->log($message);
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





    // Log for any error and session error message
    private function logError($message, $exception = null, $course = null)
    {
        session()->flash('error', $message . ($exception ? ": " . $exception->getMessage() : ''));
        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'type' => 'error',
                'message' => $exception ? $exception->getMessage() : $message,
                'course_id' => $course ? $course->course_id : $this->deleteId
            ])
            ->log($message);
    }





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
}

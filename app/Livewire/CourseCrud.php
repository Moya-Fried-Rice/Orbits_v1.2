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
    public $search = null, $deleteId, $selectedDepartment = null;
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
                $this->logSystemError('Course not found', $e, $course);
            } catch (Exception $e) {
                $this->logSystemError('Failed to load course', $e, $course);
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
                $changes = $this->changes($course);
                $this->checkForChanges($course, $changes);

            } catch (ModelNotFoundException $e) {
                $this->logSystemError('Course not found', $e, $course);
            } catch (Exception $e) {
                $this->logUpdateError('Failed to update course', $e, $course);
            } finally {
                $this->closeEdit();
            }
        }

        // Handle field update
        private function checkForChanges($course, $changes)
        {
            if ($changes) {
                $course->save();
                $this->logUpdate('Course successfully updated!', $course);
            } else {
                $this->logNoChanges('No changes were made.', $course);
            }
        }

        // Log update
        private function logUpdate($message, $course)
        {
            session()->flash('success', $message);
            activity()
                ->performedOn($course)
                ->causedBy(auth()->user())
                ->withProperties([
                    'status' => 'success',
                    'changes' => $this->changedProperties,
                    'name' => $course->course_name,
                ])
                ->event('Update')
                ->log('Course updated');
        }

        // Log update error
        private function logUpdateError($message, $exception, $course)
        {
            session()->flash('error', $message . ($exception ? ": " . $exception->getMessage() : ''));
            activity()
                ->performedOn($course)
                ->causedBy(auth()->user())
                ->withProperties([
                    'status' => 'error',
                    'message' => $exception ? $exception->getMessage() : $message
                ])
                ->event('Update')
                ->log('Failed to update course');
        }


        // Log if no changes
        private function logNoChanges($message, $course)
        {
            session()->flash('info', $message);
            activity()
                ->performedOn($course)
                ->causedBy(auth()->user())
                ->withProperties([
                    'status' => 'neutral',
                    'changes' => 'No changes were made',
                    'name' => $course->course_name])
                ->event('Update')
                ->log('No changes made to course');
        }

        // Check for changes
        private function changes($course)
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
                    $this->logSystemError('Course not found', $e, $course);
                } catch (Exception $e) {
                    $this->logSystemError('Failed to delete course', $e, $course);
                }
            }
        }

        // Check for constraints
        private function checkForRelatedSections($course)
        {
            if ($course->courseSections()->exists()) {
                $this->logDeletionError('Failed to delete course', $course);
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
            $this->logDeletion('Course successfully deleted!', $course);
        }

        // Log deletion
        private function logDeletion($message, $course)
        {
            session()->flash('deleted', $message);
            activity()
                ->performedOn($course)
                ->causedBy(auth()->user())
                ->withProperties([
                    'status' => 'success',
                    'name' => $course->course_name,
                ])
                ->event('Delete')
                ->log('Course deleted');
        }

        // Log deletion error
        private function logDeletionError($message, $course)
        {
            session()->flash('error', $message);
            activity()
                ->performedOn($course)
                ->causedBy(auth()->user())
                ->withProperties([
                    'status' => 'error',
                    'name' => $course->course_name,
                ])
                ->event('Delete')
                ->log('Failed to delete course');
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
                    $this->logSystemError('Course not found', $e, $course);
                } catch (Exception $e) {
                    $this->logSystemError('Failed to restore course', $e, $course);
                }
            }
        }

        // Check if already restored
        private function checkIfRestored($course)
        {
            if (!$course->trashed()) {
                $this->logRestorationError('Course is already active', $course);
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
            $this->logRestoration('Course successfully restored!', $course);
        }

        // Log restoration
        private function logRestoration($message, $course)
        {
            session()->flash('success', $message);
            activity()
                ->performedOn($course)
                ->causedBy(auth()->user())
                ->withProperties([
                    'status' => 'success',
                    'name' => $course->course_name,
                ])
                ->event('Restore')
                ->log('Course restored');
        }

        // Log restore error
        private function logRestorationError($message, $course)
        {
            session()->flash('error', $message);
            activity()
                ->performedOn($course)
                ->causedBy(auth()->user())
                ->withProperties([
                    'status' => 'error',
                    'name' => $course->course_name,
                ])
                ->event('Restore')
                ->log('Failed to restore course');
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

            $course = null;

            try {
                $course = $this->createCourse();
                $this->logAdd('Course successfully added!', $course);
            } catch (Exception $e) {
                $this->logAddError('Failed to create course', $e);
            } finally {
                $this->resetInputFields();
            }
        }

        // Create coruse field
        private function createCourse()
        {
            return Course::create([
                'course_name' => $this->course_name,
                'course_description' => $this->course_description,
                'course_code' => $this->course_code,
                'department_id' => $this->department_id,
            ]);
        }

        // Log course adding
        private function logAdd($message, $course)
        {
            session()->flash('success', $message);
            activity()
                ->performedOn($course)
                ->causedBy(auth()->user())
                ->withProperties([
                    'status' => 'success',
                    'name' => $this->course_name,
                ])
                ->event('Store')
                ->log('Course Created');
        }

        // Log course adding error
        private function logAddError($message, $exception) 
        {
            session()->flash('error', $message . ($exception ? ": " . $exception->getMessage() : ''));
            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'status' => 'error',
                    'message' => $exception ? $exception->getMessage() : $message
                ])
                ->event('Store')
                ->log('Failed to create course');
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





    /// Log system error with session error message
    private function logSystemError($message, $exception = null, $context = null)
    {
        // Set session error message for the UI
        session()->flash('error', $message . ($exception ? ": " . $exception->getMessage() : ''));

        // Prepare activity log properties
        $properties = [
            'status' => 'error',
            'error_message' => $exception ? $exception->getMessage() : $message,
            'context' => $context ?? 'N/A',
            'trace' => $exception ? $exception->getTraceAsString() : null,
        ];

        // Log the error in the activity log
        activity()
            ->causedBy(auth()->user())
            ->withProperties($properties)
            ->event('System Error')
            ->log($message);

        // Optionally log details to a system log file for debugging
        \Log::error($message, [
            'exception' => $exception,
            'context' => $context,
        ]);
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

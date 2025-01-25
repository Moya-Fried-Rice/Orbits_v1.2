<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;

use Livewire\Component;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Section;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;

class FacultyProfileCrud extends Component
{
    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Properties
    public $uuid;
    public $first_name, $last_name, $department_id, $phone_number, $profile_image, $email;
    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;
    public $search = null, $deleteId, $selectedDepartment = null;
    public $sortField = 'created_at', $sortDirection = 'asc';
    private $oldValues;

    public function render()
    {
        // Retrieve the faculty data based on the provided UUID
        $faculty = $this->getFacultyByUuid($this->uuid);

        // Render the view with the faculty data
        return view('livewire.faculty-profile-crud', compact('faculty'));
    }

    // Function to get faculty details by UUID, including associated department
    protected function getFacultyByUuid($uuid)
    {
        // Return the faculty record along with its associated department
        return Faculty::with('department')->where('uuid', $uuid)->first();
    }

    // Validation rules for updating faculty profile
    protected $rules = [
        'first_name' => 'required|string|max:50',
        'last_name' => 'required|string|max:50',
        'department_id' => 'required|integer|exists:departments,id',
        'phone_number' => 'nullable|string|max:20|regex:/^(\+?\d{1,3})?[\s\-\.]?(\(\d{1,4}\)[\s\-\.]?)?\d{1,4}[\s\-\.]?\d{1,4}[\s\-\.]?\d{1,9}$/',
        'profile_image' => 'nullable|max:1024',
    ];

    public function getDepartments()
    {
        // Retrieve all departments
        return Department::all();
    }

    public function getSections()
    {
        // Get the student by UUID to find the department ID
        $faculty = $this->getfacultyByUuid($this->uuid);
        $departmentId = $faculty->department_id;

        // Retrieve sections related to the faculty's program
        return Section::whereHas('courseSection.course', function ($query) use ($departmentId) {
            $query->where('courses.department_id', $departmentId); // Filter sections based on the program ID
        })->get();
    }

    public function clearMessage()
    {
        // Clear any session messages such as success, error, or info
        session()->forget(['success', 'error', 'info', 'deleted']);
    }

    private function resetInputFields()
    {
        // Reset all form input fields to their initial values
        $this->reset([
            'first_name',
            'last_name',
            'department_id',
            'phone_number',
            'profile_image',
            'email'
        ]);
    }
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
}

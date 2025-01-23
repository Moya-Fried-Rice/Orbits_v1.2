<?php

namespace App\Livewire;
use Livewire\Component;
use App\Models\Faculty;
use App\Models\Department;
use Spatie\Activitylog\Traits\LogsActivity;
use Livewire\WithPagination;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FacultyCrud extends Component
{
    use WithPagination;

    public function render()
    {
        $faculties = Faculty::query()
            ->selectRaw('faculties.*, CONCAT(faculties.first_name, " ", faculties.last_name) AS full_name, departments.department_name')
            ->leftJoin('departments', 'faculties.department_id', '=', 'departments.department_id') // Join with departments table
            ->when($this->selectedDepartment, function ($query) {
                return $query->where('departments.department_id', $this->selectedDepartment); // Use selectedDepartment for filtering
            })
            ->when($this->search, function ($query) {
                $query->having('full_name', 'like', '%' . $this->search . '%'); // Use HAVING for full_name virtual column filtering
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10); // Adjust pagination as needed

        return view('livewire.faculty-crud', compact('faculties'));
    }

    // Public properties for faculty data and modal states.
    public $first_name, $last_name, $department_id, $phone_number, $profile_image, $username, $password, $email;
    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;
    public $search = null, $deleteId, $selectedDepartment = null;
    public $sortField = 'created_at', $sortDirection = 'asc';

    // Validation
    protected $rules = [
        'first_name' => 'required|string|max:50',
        'last_name' => 'required|string|max:50',
        'department_id' => 'required|integer|exists:departments,id',
        'phone_number' => 'nullable|string|max:15|regex:/^\\+?[0-9]*$/',
        'profile_image' => 'nullable|image|max:2048', // Maximum size of 2MB
        'username' => 'required|string|max:50|unique:faculties,username',
        'password' => 'required|string|min:8',
        'email' => 'required|email|max:255|unique:faculties,email',
    ];

    // Listen to dispatched events
    protected $listeners = [
        'departmentSelected' => 'departmentSearch',
        'searchPerformed' => 'searchPerformed'
    ];

    // Search Section
    public function searchPerformed($searchTerm)
    {
        $this->search = $searchTerm;
        $this->resetPage();
    }

    // Filter section by department
    public function departmentSearch($departmentId)
    {
        $this->selectedDepartment = $departmentId;
        $this->resetPage();
    }

    // Sort faculties by field and direction
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
}

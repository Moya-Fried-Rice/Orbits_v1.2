<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Program;
use App\Models\Department;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

use Livewire\WithPagination;

class ProgramCrud extends Component
{
    use WithPagination;

    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Properties
    public $program_code, $program_name, $abbreviation, $program_description, $department_id;
    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;
    public $search = null, $deleteId, $selectedDepartment = null;
    public $sortField = 'created_at', $sortDirection = 'asc';
    
    public function render()
    {
        $programs = Program::query()
            ->selectRaw('programs.*, departments.department_name')
            ->leftJoin('departments', 'programs.department_id', '=', 'departments.department_id') // Join with departments table
            ->when($this->selectedDepartment, function ($query) {
                return $query->where('departments.department_id', $this->selectedDepartment); // Filter by department
            })
            ->when($this->search, function ($query) {
                $query->where('program_name', 'like', '%' . $this->search . '%') // Search by program name
                      ->orWhere('program_code', 'like', '%' . $this->search . '%'); // Search by program code
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(11); // Adjust pagination as needed

        return view('livewire.program-crud', compact('programs'));
    }

    // Validation rules
    protected $rules = [
        'program_code' => 'required|string|max:20|unique:programs,program_code',
        'program_name' => 'required|string|max:100',
        'abbreviation' => 'nullable|string|max:10',
        'program_description' => 'nullable|string|max:500',
        'department_id' => 'required|integer|exists:departments,id',
    ];

    // Listeners for dispatched events
    protected $listeners = [
        'departmentSelected' => 'departmentFilter',
        'searchPerformed' => 'searchPerformed',
    ];

    // Search Section
    public function searchPerformed($searchTerm)
    {
        $this->search = $searchTerm;
        $this->resetPage();
    }

    // Filter by department
    public function departmentFilter($departmentId)
    {
        $this->selectedDepartment = $departmentId;
        $this->resetPage();
    }

    // Sort programs by field and direction
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
    //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
}

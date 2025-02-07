<?php

namespace App\Livewire;

use App\Models\Faculty;
use App\Models\Department;

use Livewire\Component;
use Livewire\WithPagination;

class Results extends Component
{
    use WithPagination;

    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Properties
    public $search = null, $deleteId, $selectedDepartment = null;
    public $sortField = 'created_at', $sortDirection = 'asc';
    
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
            ->paginate(11); // Adjust pagination as needed

        return view('livewire.results', compact('faculties'));
    }

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
}

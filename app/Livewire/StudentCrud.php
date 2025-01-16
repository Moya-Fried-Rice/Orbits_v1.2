<?php

namespace App\Livewire;
use Livewire\Component;
use App\Models\Student;
use App\Models\Department;
use App\Models\Program;
use Spatie\Activitylog\Traits\LogsActivity;
use Livewire\WithPagination;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class StudentCrud extends Component
{
    use WithPagination;

    public function render()
    {
        $students = Student::query()
            ->selectRaw('students.*, CONCAT(students.first_name, " ", students.last_name) AS full_name, programs.program_code')
            ->leftJoin('programs', 'students.program_id', '=', 'programs.program_id') // Join with programs table
            ->when($this->selectedProgram, function ($query) {
                return $query->where('programs.program_id', $this->selectedProgram); // Use selectedProgram for filtering
            })
            ->when($this->search, function ($query) {
                $query->having('full_name', 'like', '%' . $this->search . '%'); // Use HAVING for full_name virtual column filtering
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(12); // Adjust pagination as needed

        return view('livewire.student-crud', compact('students'));
    }

    // Public properties for student data and modal states.
    public $first_name, $last_name, $program_id, $phone_number, $profile_image;
    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;
    public $search = null, $deleteId, $selectedProgram = null;
    public $sortField = 'created_at', $sortDirection = 'asc';

    // Validation
    protected $rules = [
        'first_name' => 'required|string|max:50',
        'last_name' => 'required|string|max:50',
        'program_id' => 'required|integer|exists:programs,id',
        'phone_number' => 'nullable|string|max:15|regex:/^\+?[0-9]*$/',
        'profile_image' => 'nullable|image|max:2048', // Maximum size of 2MB
    ];

    // Listen to dispatched events
    protected $listeners = [
        'programSelected' => 'programSearch',
        'searchPerformed' => 'searchPerformed'
    ];

    // Search Section
    public function searchPerformed($searchTerm)
    {
        $this->search = $searchTerm;
        $this->resetPage();
    }

    // Filter section by program
    public function programSearch($programId)
    {
        $this->selectedProgram = $programId;
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
        $this->selectedProgram = '';
        $this->resetPage();
        $this->dispatch('clearFilters');
    }

    // Fetch all programs for dropdown
    public function getPrograms()
    {
        return Program::all();
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

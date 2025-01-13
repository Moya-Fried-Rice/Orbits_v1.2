<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Spatie\Activitylog\Traits\LogsActivity;
use Livewire\WithPagination;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class AccountCrud extends Component
{
    use WithPagination;

    public function render()
    {
        $accounts = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedRole, fn($query) => $query->where('role', $this->selectedRole))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(12);

        return view('livewire.account-crud', compact('accounts'));
    }

    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;
    public $search = null, $deleteId, $selectedRole = null;
    public $sortField = 'created_at', $sortDirection = 'asc';

    protected $listeners = [
        'searchPerformed' => 'searchPerformed'
    ];

    protected $rules = [
        'user_id' => 'required|integer|exists:users,id',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
        'role' => 'required|string|in:admin,student,faculty,program_chair',
    ];
    
    public function searchPerformed($searchTerm)
    {
        $this->search = $searchTerm;
        $this->resetPage();
    }

    public function sortBy($field)
    {
        $this->sortField = $this->sortField === $field ? $this->sortField : $field;
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedRole = '';
        $this->resetPage();
        $this->dispatch('clearFilters');
    }

    public function clearMessage()
    {
        session()->forget(['success', 'error', 'info', 'deleted']);
    }
}

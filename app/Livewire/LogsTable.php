<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use App\Models\Department;

class LogsTable extends Component
{
    public $logs;
    public $sortField = 'created_at'; // Default sorting field
    public $sortDirection = 'desc'; // Default sorting direction

    // This method is called when the component is mounted
    public function mount()
    {
        // Retrieve all logs and apply sorting
        $this->logs = Activity::orderBy($this->sortField, $this->sortDirection)->get();
    }

    // Fetch all departments for dropdown
    public function getDepartment($departmentId)
    {
        $department = Department::find($departmentId); // Or use another method to fetch department
        return $department ? $department->department_code : null; // Return the department name or null if not found
    }

    // Method to update sorting
    public function sortBy($field)
    {
        // If the current sort field is clicked again, toggle the direction
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc'; // Default to ascending when sorting by a new field
        }

        // Re-fetch the logs with updated sorting
        $this->logs = Activity::orderBy($this->sortField, $this->sortDirection)->get();
    }

    public function render()
    {
        return view('livewire.logs-table');
    }
}

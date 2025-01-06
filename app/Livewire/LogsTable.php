<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

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

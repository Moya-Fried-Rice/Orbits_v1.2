<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Department;

class SearchDepartments extends Component
{
    public $searchDepartment = '';  // Holds the search input
    public $departments = [];       // Holds the filtered departments

    // This method is called whenever the searchDepartment property is updated
    public function updatedSearchDepartment()
    {
        if (empty($this->searchDepartment)) {
            // If the search input is empty, get all departments
            $this->departments = Department::all();
        } else {
            // Filter departments based on the search input
            $this->departments = Department::where('department_code', 'like', '%' . $this->searchDepartment . '%')
                ->orWhere('department_name', 'like', '%' . $this->searchDepartment . '%')
                ->get();
        }
    }

    // This method is called when a department is selected
    public function selectDepartment($departmentId)
    {
        // Find the department by its ID
        $department = Department::find($departmentId);

        if ($department) {
            // Update the input field with the selected department's code
            $this->searchDepartment = $department->department_code;

            // Optionally, clear the dropdown list
            $this->departments = [];

            // Dispatch an event with the selected department's ID
            $this->dispatch('departmentSelected', $department->department_id);
        }
    }

    // Render the Livewire component view
    public function render()
    {
        return view('livewire.search-departments');
    }
}

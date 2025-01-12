<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Faculty;

class SearchFaculties extends Component
{

    public $searchFaculty = '';  // Holds the search input
    public $faculties = [];      // Holds the filtered faculties

    // Listen for the clearFilters event
    protected $listeners = ['clearFilters' => 'clearFilters']; 

    // This method will clear the search term
    public function clearFilters()
    {
        $this->searchFaculty = '';
        $this->faculties = Faculty::all(); // Fetch all faculties
    }

    // This method is called whenever the searchFaculty property is updated
    public function updatedSearchFaculty()
    {
        if (empty($this->searchFaculty)) {
            // If the search input is empty, get all faculties
            $this->faculties = Faculty::all();
        } else {
            // Filter faculties based on the search input
            $this->faculties = Faculty::whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $this->searchFaculty . '%'])
            ->get();
        }
    }

    // This method is called when a faculty is selected
    public function selectFaculty($facultyId)
    {
        // Find the faculty by its ID
        $faculty = Faculty::find($facultyId);

        if ($faculty) {
            // Update the input field with the selected faculty's code
            $this->searchFaculty = $faculty->first_name . ' ' . $faculty->last_name;

            // Optionally, clear the dropdown list
            $this->faculties = [];

            // Dispatch an event with the selected faculty's ID
            $this->dispatch('facultySelected', $faculty->faculty_id);
        }
    }

    public function render()
    {
        return view('livewire.search-faculties');
    }
}

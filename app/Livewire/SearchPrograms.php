<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Program;

class SearchPrograms extends Component
{
    public $searchProgram = '';  // Holds the search input
    public $programs = [];       // Holds the filtered programs

    // Listen for the clearFilters event
    protected $listeners = ['clearFilters' => 'clearFilters']; 

    // This method will clear the search term
    public function clearFilters()
    {
        $this->searchProgram = '';
        $this->programs = Program::all();
    }

    // This method is called whenever the searchProgram property is updated
    public function updatedSearchProgram()
    {
        if (empty($this->searchProgram)) {
            // If the search input is empty, get all programs
            $this->programs = Program::all();
        } else {
            // Filter programs based on the search input
            $this->programs = Program::where('program_code', 'like', '%' . $this->searchProgram . '%')
                ->orWhere('program_name', 'like', '%' . $this->searchProgram . '%')
                ->get();
        }
    }

    // This method is called when a program is selected
    public function selectProgram($programId)
    {
        // Find the program by its ID
        $program = Program::find($programId);

        if ($program) {
            // Update the input field with the selected program's code
            $this->searchProgram = $program->program_code;

            // Optionally, clear the dropdown list
            $this->programs = [];

            // Dispatch an event with the selected program's ID
            $this->dispatch('programSelected', $program->program_id);
        }
    }

    // Render the Livewire component view
    public function render()
    {
        return view('livewire.search-programs');
    }
}
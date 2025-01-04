<?php

namespace App\Livewire;

use Livewire\Component;

class SearchBar extends Component
{

    public $search = '';

    // Listen for the clearFilters event
    protected $listeners = ['clearFilters' => 'clearFilters']; 

    // This method will clear the search term
    public function clearFilters()
    {
        $this->search = '';
    }

    // This method will dispatch the search event when the search term is updated
    public function updatedSearch($value)
    {
        $this->dispatch('searchPerformed', $value); // Dispatch the event with the search term
    }

    public function render()
    {
        return view('livewire.search-bar');
    }
}

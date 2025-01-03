<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    protected $layout = 'layouts.app';
    
    public function render()
    {
        return view('livewire.dashboard');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserProfile extends Component
{
    public function render()
    {
        // Get the authenticated user
        $user = Auth::user();
        // Return the view and pass the user to it
        return view('livewire.user-profile', compact('user'));
    }
}


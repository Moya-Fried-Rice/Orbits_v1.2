<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserProfile extends Component
{
    use WithFileUploads;

    public $user;
    public $name;
    public $email;
    public $password;
    public $profile_picture;
    public $newProfilePicture;
    public $role;
    public $showSaveMessage = false;

    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->role = $this->user->role;
        $this->profile_picture = $this->user->profile_picture;
    }

    public function updatedNewProfilePicture()
    {
        $this->validate([
            'newProfilePicture' => 'image|max:2048', // Max 2MB
        ]);

        $this->showSaveMessage = true; // Show "Save Changes" message
    }

    public function saveChanges()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // Save profile picture if a new one was uploaded
        if ($this->newProfilePicture) {
            if ($this->user->profile_picture) {
                Storage::disk('public')->delete($this->user->profile_picture);
            }
            $path = $this->newProfilePicture->store('profile_pictures', 'public');
            $this->user->profile_picture = $path;
            $this->profile_picture = $path;
        }

        // Update user details
        $this->user->name = $this->name;
        $this->user->email = $this->email;

        $this->user->save();
        $this->showSaveMessage = false;
        session()->flash('message', 'Profile updated successfully.');
    }

    public function updatePassword()
    {
        $this->validate([
            'password' => 'required|min:8',
        ]);

        $this->user->password = Hash::make($this->password);
        $this->user->save();

        // Clear input field
        $this->password = '';

        session()->flash('password_message', 'Password changed successfully.');
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}

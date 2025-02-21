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
    public $profile_image;
    public $newProfilePicture;
    public $role;
    public $showSaveMessage = false;

    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->user_name;
        $this->email = $this->user->email;
        $this->role = $this->user->role;
        $this->profile_image = $this->user->profile_image;
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

        // Save profile picture if a new one was uploaded
        if ($this->newProfilePicture) {
            if ($this->user->profile_image) {
                Storage::disk('public')->delete($this->user->profile_image);
            }
            $path = $this->newProfilePicture->store('profile_images', 'public');
            $this->user->profile_image = $path;
            $this->profile_image = $path;
        }

        $this->user->save();
        $this->showSaveMessage = false;
        session()->flash('message', 'Profile updated successfully.');
    }
    
    public function clearMessage()
    {
        session()->forget(['message', 'error', 'info', 'deleted']);
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

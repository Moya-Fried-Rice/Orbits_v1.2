<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;

use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Validate;

class UserProfile extends Component
{
    use WithFileUploads;

    public $user;
    public $name;
    public $email;

    public $password;
    public $newPassword='';
    public $confirmPassword;
    public $passwordRequirements = [
        'length' => false,
        'uppercase' => false,
        'lowercase' => false,
        'number' => false,
        'special' => false,
    ];

    public $profile_image;
    public $newProfilePicture;
    public $role;
    public $showSaveMessage = false;
    public $showPasswordSection = false;
    public $showPasswordRequirements = false;
    public $showValidationChecklist = false;

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
    

//Password update with concdtiton
public function updatePassword()
{
    //
    $this->validate([
        'password' => 'required',
        'newPassword' => [
            'required',
            'min:8',
            'regex:/[A-Z]/',
            'regex:/[a-z]/',
            'regex:/[0-9]/',      
            'regex:/[@$!%*?&#]/', 
        ],
        'confirmPassword' => 'required|same:newPassword', 
    ]);

    if (!Hash::check($this->password, Auth::user()->password)) {
        throw ValidationException::withMessages(['password' => 'Current password is incorrect.']);
    }

    Auth::user()->update([
        'password' => Hash::make($this->newPassword),
    ]);

    $this->password = '';
    $this->newPassword = '';
    $this->confirmPassword = '';

    $this->showPasswordModal = false;


    session()->flash('password_message', 'Password changed successfully.');
}


    //password change requirment
    public function updatedNewPassword($value)
    {
        // Show validation checklist when there's input in the password field
        $this->showValidationChecklist = !empty($value);
        
        $this->passwordRequirements = [
            'length' => is_string($value) && strlen($value) >= 8,
            'uppercase' => is_string($value) && preg_match('/[A-Z]/', $value),
            'lowercase' => is_string($value) && preg_match('/[a-z]/', $value),
            'number' => is_string($value) && preg_match('/[0-9]/', $value),
            'special' => is_string($value) && preg_match('/[\W]/', $value),
        ];
    }
    
    public function togglePasswordSection()
    {
        $this->showPasswordSection = !$this->showPasswordSection;
    }

    public function render()
    {
        return view('livewire.user-profile');
        
    }
}

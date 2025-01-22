<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Student;
use App\Models\Program;

class StudentProfileCrud extends Component
{
    public $uuid;
    public $student;

    public function mount($uuid)
    {
        $this->uuid = $uuid;
        // Eager load the course sections for the student
        $this->student = Student::with('courseSections')->where('uuid', $uuid)->first();
    }

    public function render()
    {
        return view('livewire.student-profile-crud');
    }

    public function getDepartments()
    {
        return Program::all();
    }
}

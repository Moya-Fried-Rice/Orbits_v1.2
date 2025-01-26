<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Survey;
use App\Models\Student;
use App\Models\StudentCourse;
use App\Models\CourseSection;
use App\Models\Faculty;

class SurveyCrud extends Component
{
    public function render()
    {
        $surveys = Survey::all();
        
        return view('livewire.survey-crud', compact('surveys'));
    }
}

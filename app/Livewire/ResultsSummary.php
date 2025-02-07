<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Faculty;

class ResultsSummary extends Component
{   
    public $uuid;
    public function render()
    {
        $faculty = $this->getFacultyByUuid($this->uuid);

        return view('livewire.results-summary', compact('faculty'));
    }

    protected function getFacultyByUuid($uuid)
    {
        // Return the faculty record along with its associated department
        return Faculty::with('facultyCourses')->where('uuid', $uuid)->first();
    }
}

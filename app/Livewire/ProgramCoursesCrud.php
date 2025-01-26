<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Livewire\Component;
use App\Models\Program;
use App\Models\ProgmraCourse;

class ProgramCoursesCrud extends Component
{

    public $uuid;
    public $program_id, $ProgramCourse;
    public $showDeleteConfirmation = false;
    public $showEditForm = false, $showEditConfirmation = false;
    public $showAddForm = false, $showAddConfirmation = false;
    public $deleteId;
    
    public function render()
    {
        // Retrieve the section data based on the provided UUID
        $program = $this->getProgramByUuid($this->uuid);

        // Render the view with the section data
        return view('livewire.program-courses-crud', compact('program'));
    }

    protected function getProgramByUuid($uuid)
    {
        // Return the Section record along with its associated course section
        return Program::with('programCourse')->where('uuid', $uuid)->first();
    }

    public function clearMessage()
    {
        // Clear any session messages such as success, error, or info
        session()->forget(['success', 'error', 'info', 'deleted']);
    }

    private function resetInputFields()
    {
        // Reset all form input fields to their initial values
        $this->reset([
            'course_id'
        ]);
    }
}

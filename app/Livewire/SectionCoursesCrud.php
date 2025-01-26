<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;

use Livewire\Component;
use App\Models\Section;

class SectionCoursesCrud extends Component
{
    public $uuid;

    public function render()
    {
        // Retrieve the section data based on the provided UUID
        $section = $this->getSectionByUuid($this->uuid);

        // Render the view with the section data
        return view('livewire.section-courses-crud', compact('section'));
    }

    protected function getSectionByUuid($uuid)
    {
        // Return the Section record along with its associated course section
        return Section::with('courseSection')->where('uuid', $uuid)->first();
    }
}

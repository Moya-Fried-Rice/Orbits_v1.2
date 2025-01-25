<select 
    class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200"
    id="course_section_id" 
    wire:model="course_section_id">
    <option value="">Select a section</option>
    @foreach ($this->getSections() as $section) <!-- Assuming this method fetches sections -->
        <optgroup label="{{ $section->section_code }}"> 
            @foreach ($section->courseSection as $courseSection) <!-- Assuming courses is a relationship -->
                <option value="{{ $courseSection->course_section_id }}">
                    {{ $courseSection->course->course_name }}
                </option>
            @endforeach
        </optgroup>
    @endforeach
</select>

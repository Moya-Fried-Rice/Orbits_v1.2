<div class="relative">
    <select 
        class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200"
        id="course_section_id" 
        wire:model="course_section_id"
        multiple
        size="10">
        @foreach ($this->getCourseSections()->groupBy('section.section_code') as $sectionCode => $sections)
            <optgroup label="{{ $sectionCode }}">
                @foreach ($sections as $section)
                    <option value="{{ $section->course_section_id }}">
                        {{ $section->course->course_name }}
                    </option>
                @endforeach
            </optgroup>
        @endforeach
    </select>
    <div class="text-sm text-gray-500 mt-1">
        Hold <span class="font-bold">Ctrl (Windows)</span> or <span class="font-bold">Cmd (Mac)</span> to select multiple courses.
    </div>
</div>
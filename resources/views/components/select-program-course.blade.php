<div class="relative">
    <select 
        class="p-1 bg-[#F8F8F8] w-full border rounded-lg border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200"
        id="course_id" 
        wire:model="course_id"
        size="10" 
        multiple>
        @foreach ($this->getPrograms()->programCourse->groupBy(function($programCourse) {
            return $this->ordinal($programCourse->year_level) . ' Year - ' . $this->ordinal($programCourse->semester) . ' Semester:';
        }) as $yearSemester => $programCourses)
            <optgroup class="mb-2" label="{{ $yearSemester }}">
                @foreach ($programCourses as $programCourse)
                    <option class="hover:bg-[#DDD]" value="{{ $programCourse->course->course_id }}">
                        {{ $programCourse->course->course_name }}
                    </option>
                @endforeach
            </optgroup>
        @endforeach
    </select>
    <div class="text-sm text-gray-500 mt-1">
        Hold <span class="font-bold">Ctrl (Windows)</span> or <span class="font-bold">Cmd (Mac)</span> to select multiple courses.
    </div>
</div>

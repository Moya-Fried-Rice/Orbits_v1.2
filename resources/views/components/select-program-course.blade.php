<select 
    class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200"
    id="course_id" 
    wire:model="course_id">
    <option value="">Select a course</option>
    @foreach ($this->getPrograms()->programCourse as $programCourse)
        <option value="{{ $programCourse->course->course_id }}">{{ $programCourse->course->course_name }}</option>
    @endforeach
</select>
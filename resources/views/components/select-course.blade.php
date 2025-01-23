<select 
    class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200"
    id="course_id" 
    wire:model="course_id">
    <option value="">Select a course</option>
    @foreach ($this->getDepartments() as $department)
        <optgroup label="{{ $department->department_name }}"> 
            @foreach ($department->course as $course) <!-- Assuming courses is a relationship -->
                <option value="{{ $course->course_id }}">{{ $course->course_name }}</option>
            @endforeach
        </optgroup>
    @endforeach
</select>
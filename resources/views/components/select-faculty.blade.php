<select 
    class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200"
    id="faculty_id" 
    wire:model="faculty_id">
    <option value="">Unassigned</option>
    
    @foreach ($this->getDepartments() as $department)
        <optgroup label="{{ $department->department_name }}">
            @foreach ($department->faculties as $faculty)
                <option value="{{ $faculty->faculty_id }}">{{ $faculty->first_name }} {{ $faculty->last_name }}</option>
            @endforeach
        </optgroup>
    @endforeach
</select>
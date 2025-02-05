<select 
    class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200"
    id="program_id" 
    wire:model="program_id">
    <option value="">Select a program</option>

    @foreach ($this->getDepartments() as $department)
        <optgroup label="{{ $department->department_name }}"> 
            @foreach ($department->programs as $program) <!-- Assuming programs is a relationship -->
                <option value="{{ $program->program_id }}">{{ $program->program_name }}</option>
            @endforeach
        </optgroup>
    @endforeach
</select> 
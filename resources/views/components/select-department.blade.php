<select 
    class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200"
    id="department_id" 
    wire:model="department_id">
        <option value="">Select a department</option>
        @foreach ($this->getDepartments() as $department)
            <option value="{{ $department->department_id }}">{{ $department->department_name }}</option>
        @endforeach
</select>
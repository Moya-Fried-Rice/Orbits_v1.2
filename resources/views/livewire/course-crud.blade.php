<div class="bg-white">

    <x-system-notification />
    
    <div class="p-5 pb-0 flex flex-wrap justify-between items-center">

        <!-- Filters and Search Bar Section -->
        <div class="flex flex-wrap gap-4 items-center justify-start w-full sm:w-auto">
    
            <!-- Search Bar -->
            <livewire:search-bar />
    
            <!-- Search Department -->
            <livewire:search-departments />
    
            <!-- Clear Button -->
            <x-clear-button />
    
        </div>
    
        <!-- Add Course Button -->
        <x-add-button add="Course" />
    
    </div>
    
    <!-- Course List -->
    <x-table :action="true">
        <x-slot name="header">

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="course_code"
                label="Course Code"/>

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="course_name"
                label="Course Name"/>

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="course_description"
                label="Course Description"/>

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="department_id"
                label="Department"/>

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="created_at"
                label="Created At"/>

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="updated_at"
                label="Updated At"/>

        </x-slot>

        <x-slot name="body">
            @if($courses->isEmpty())
            <tr>
                <td colspan="7" class="text-center py-4">No courses found.</td>
            </tr>
            @else
            @foreach ($courses as $course)
            <tr class="font-normal border border-[#DDD] text-[#666]-100 hover:bg-[#F8F8F8] transition-colors duration-100">
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $course->course_code }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $course->course_name }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-sm">{{ $course->course_description }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $course->department->department_code }}</td>
                <td class="py-2 whitespace-nowrap px-4">{{ $course->created_at->format('Y-m-d H:i') }}</td>
                <td class="py-2 whitespace-nowrap px-4">{{ $course->updated_at->format('Y-m-d H:i') }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">
                    <div class="flex items-center justify-end space-x-2">
                        <button wire:click="edit({{ $course->course_id }})">
                            <img src="{{ asset('assets/icons/edit.svg') }}" alt="Edit" class="hover:transform hover:rotate-12 bg-[#DDD] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                        </button>
                        <button wire:click="delete({{ $course->course_id }})">
                            <img src="{{ asset('assets/icons/delete.svg') }}" alt="Delete" class="hover:transform hover:rotate-12 bg-[#666] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                        </button>
                    </div>
                </td>
            </tr>            
            @endforeach
            @endif
        </x-slot>
    </x-table>

    <!-- Pagination -->
    <div class="p-5">
        {{ $courses->links() }}
    </div>

{{-- Modal Delete --}}
<x-delete-modal label="course"/>

{{-- Modal Edit --}}
<x-edit-modal label="course">

    <!-- Course Name -->
    <x-add-modal-data name="course_name" label="Course Name:">
        <input 
            class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
            type="text" 
            id="course_name" 
            wire:model="course_name">
    </x-add-modal-data>

    <!-- Course Code -->
    <x-add-modal-data name="course_code" label="Course Code:">
        <input 
            class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
            type="text" 
            id="course_code" 
            wire:model="course_code">
    </x-add-modal-data>

    <!-- Course Description -->
    <x-add-modal-data name="course_description" label="Course Description:">
        <textarea 
            class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
            id="course_description" 
            rows="4"
            wire:model="course_description"></textarea>
    </x-add-modal-data>

    <!-- Department -->
    <x-add-modal-data name="department_id" label="Department:">
        <select 
            class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200"
            id="department_id" 
            wire:model="department_id">
            <option value="">Select a department</option>
            @foreach ($this->getDepartments() as $department)
                <option value="{{ $department->department_id }}">{{ $department->department_name }}</option>
            @endforeach
        </select>
    </x-add-modal-data>


</x-edit-modal>


{{-- Modal Add --}}
<x-add-modal label="course">

    <!-- Course Name -->
    <x-add-modal-data name="course_name" label="Course Name:">
        <input 
            class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
            type="text" 
            id="course_name" 
            wire:model="course_name">
    </x-add-modal-data>

    <!-- Course Code -->
    <x-add-modal-data name="course_code" label="Course Code:">
        <input 
            class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
            type="text" 
            id="course_code" 
            wire:model="course_code">
    </x-add-modal-data>

    <!-- Course Description -->
    <x-add-modal-data name="course_description" label="Course Description:">
        <textarea 
            class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
            id="course_description" 
            rows="4"
            wire:model="course_description"></textarea>
    </x-add-modal-data>

    <!-- Department -->
    <x-add-modal-data name="department_id" label="Department:">
        <select 
            class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200"
            id="department_id" 
            wire:model="department_id">
                <option value="">Select a department</option>
                @foreach ($this->getDepartments() as $department)
                    <option value="{{ $department->department_id }}">{{ $department->department_name }}</option>
                @endforeach
        </select>
    </x-add-modal-data>

</x-add-modal>
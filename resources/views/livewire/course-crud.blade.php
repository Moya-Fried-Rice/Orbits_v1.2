<div class="bg-white">

    <!-- Notification -->
    @if (session()->has('success'))
    <div class="bg-green-100 border-l-4 border-[#87C26A] text-[#87C26A] p-4 flex justify-between items-center" role="alert">
        <div class="flex gap-2">
            <img src="{{ asset('assets/icons/success.svg') }}" alt="Success">
            {{ session('success') }}
        </div>
        <button type="button" class="text-[#87C26A] mr-5" wire:click="clearMessage">
            <i class="fa fa-times"></i>
        </button>
    </div>
    @elseif (session()->has('error'))
    <div class="bg-red-100 border-l-4 border-[#923534] text-[#923534] p-4 flex justify-between items-center" role="alert">
        <div class="flex gap-2">
            <img src="{{ asset('assets/icons/error.svg') }}" alt="Error">
            {{ session('error') }}
        </div>
        <button type="button" class="text-[#923534] mr-5" wire:click="clearMessage">
            <i class="fa fa-times"></i>
        </button>
    </div>
    @elseif (session()->has('info'))
    <div class="bg-blue-100 border-l-4 border-[#4A90E2] text-[#4A90E2] p-4 flex justify-between items-center" role="alert">
        <div class="flex gap-2">
            <img src="{{ asset('assets/icons/info.svg') }}" alt="Info">
            {{ session('info') }}
        </div>
        <button type="button" class="text-[#4A90E2] mr-5" wire:click="clearMessage">
            <i class="fa fa-times"></i>
        </button>
    </div>
    @endif
    
    <div class="p-5 pb-0 flex flex-wrap justify-between items-center">

        <!-- Filters and Search Bar Section -->
        <div class="flex flex-wrap gap-4 items-center justify-start w-full sm:w-auto">
    
            <!-- Search Bar -->
            <livewire:search-bar />
    
            <!-- Search Department -->
            <livewire:search-departments />
    
            <!-- Clear Button -->
            <div class="flex flex-cols w-full sm:w-auto">
                <button wire:click="clearFilters" class="w-full sm:w-auto px-4 py-2 rounded hover:bg-[#F8F8F8] transition duration-100">
                    <i class="fa fa-eraser"></i> Clear
                </button>
            </div>
    
        </div>
    
        <!-- Add Course Button -->
        <div class="w-full sm:w-auto mt-4 sm:mt-0">
            <button wire:click="add" class="w-full sm:w-auto bg-[#923534] text-white py-2 px-4 rounded flex items-center gap-1 transition duration-100 hover:transform hover:scale-105">
                <img src="{{ asset('assets/icons/add.svg') }}" alt="Add">Course
            </button>
        </div>
    
    </div>
    
    <!-- Course List -->
    <x-table>
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
                    <div class="flex items-center space-x-2">
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

        @error('course_name') 
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </x-add-modal-data>

    <!-- Course Code -->
    <x-add-modal-data name="course_code" label="Course Code:">
        <input 
            class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
            type="text" 
            id="course_code" 
            wire:model="course_code">

        @error('course_code') 
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </x-add-modal-data>

    <!-- Course Description -->
    <x-add-modal-data name="course_description" label="Course Description:">
        <textarea 
            class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
            id="course_description" 
            wire:model="course_description"></textarea>

        @error('course_description') 
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
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

        @error('department_id') 
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
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

        @error('course_name') 
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </x-add-modal-data>

    <!-- Course Code -->
    <x-add-modal-data name="course_code" label="Course Code:">
        <input 
            class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
            type="text" 
            id="course_code" 
            wire:model="course_code">

        @error('course_code') 
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </x-add-modal-data>

    <!-- Course Description -->
    <x-add-modal-data name="course_description" label="Course Description:">
        <textarea 
            class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
            id="course_description" 
            wire:model="course_description"></textarea>

        @error('course_description') 
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
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

        @error('department_id') 
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </x-add-modal-data>

</x-add-modal>
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
    @endif
    
    <div class="p-5 pb-0 flex flex-wrap justify-between items-center">

        <!-- Title -->
        {{-- <div class="text-xl flex items-center justify-center h-16">
            <div>
            Course Management
            </div>
        </div> --}}

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
            <button wire:click="showModal" class="w-full sm:w-auto bg-[#923534] text-white py-2 px-4 rounded flex items-center gap-1 transition duration-100 hover:transform hover:scale-105">
                <img src="{{ asset('assets/icons/add.svg') }}" alt="Add">Course
            </button>
        </div>
    
    </div>
    
    <!-- Course List -->
    <x-table>
        <x-slot name="header">

            <x-table-data
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="course_code"
                label="Course Code"/>

            <x-table-data
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="course_name"
                label="Course Name"/>

            <x-table-data
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="course_description"
                label="Course Description"/>

            <x-table-data
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="department_id"
                label="Department"/>

            <x-table-data
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="created_at"
                label="Created At"/>

            <x-table-data
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

{{-- Delete Confirmation --}}
@if ($showDeleteConfirmation)
<div class="fixed inset-0 bg-black bg-opacity-20 overflow-y-auto flex justify-center items-center z-30" wire:click="cancelDelete">
    <div class="bg-[#F8F8F8] rounded-lg w-full max-w-lg sm:max-w-md mx-auto relative">

        {{-- Header --}}
        <div class="p-4 flex justify-center font-semibold items-center bg-white font-TT rounded-t-lg relative">
            <button wire:click="cancelDelete" class="font-thin text-lg absolute left-4">
                <i class="fa fa-times"></i>
            </button>
            <h3 class="text-lg sm:text-xl">Delete Confirmation</h3>
        </div>

        {{-- Body --}}
        <div class="flex flex-col items-center px-6 py-4 text-center">
            <img src="{{ asset('assets/icons/danger.svg') }}" class="w-20 h-20 mb-4" alt="Warning">
            <p class="text-gray-700 text-sm sm:text-base">Are you sure you want to delete this course?</p>
            <p class="text-xs text-gray-500 mt-2 sm:text-sm">This action cannot be undone.</p>
        </div>

        {{-- Footer --}}
        <div class="p-4 flex flex-wrap justify-center gap-4 bg-white rounded-b-lg">
            <button wire:click="confirmDelete" class="transition duration-100 bg-[#923534] text-white px-4 py-2 rounded hover:bg-[#7B2323] focus:outline-none focus:ring focus:ring-red-300">
                Yes, Delete
            </button>
            <button wire:click="cancelDelete" class="transition duration-100 bg-[#666] text-white px-4 py-2 rounded hover:bg-zinc-600 focus:outline-none focus:ring focus:ring-gray-300">
                Cancel
            </button>
        </div>
    </div>
    
</div>
@endif


{{-- Modal Add/Edit --}}
@if ($showConfirmation)
<div class="fixed inset-0 bg-black bg-opacity-20 overflow-y-auto flex justify-center items-center z-30" wire:click.self="closeModal">
    <div class="bg-[#F8F8F8] rounded-lg w-full max-w-lg sm:max-w-md md:max-w-xl lg:max-w-2xl mx-auto relative">

        {{-- Header --}}
        <div class="p-4 flex justify-center font-semibold items-center bg-white font-TT rounded-t-lg relative">
            <button wire:click="closeModal" class="font-thin text-lg absolute left-4">
                <i class="fa fa-times"></i>
            </button>
            @if ($updateMode)
                <h3 class="text-lg">Edit Course</h3>
            @else
                <h3 class="text-lg">Add Course</h3>
            @endif
        </div>

        {{-- Body --}}
        <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}">
            <div class="space-y-4 py-4 max-h-[70vh] px-6 overflow-y-auto">
                <div>
                    <label for="course_name" class="block text-sm font-medium text-gray-700">Course Name</label>
                    <input type="text" wire:model="course_name" id="course_name" class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200"/>
                    @error('course_name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="course_code" class="block text-sm font-medium text-gray-700">Course Code</label>
                    <input type="text" wire:model="course_code" id="course_code" class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200"/>
                    @error('course_code') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="course_description" class="block text-sm font-medium text-gray-700">Course Description</label>
                    <textarea rows="4" wire:model="course_description" id="course_description" class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200"></textarea>
                    @error('course_description') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
                    <select wire:model="department_id" id="department_id" class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200">
                        <option value="">Select Department</option>
                        @foreach ($this->getDepartments() as $department)
                            <option value="{{ $department->department_id }}">{{ $department->department_code }}</option>
                        @endforeach
                    </select>
                    @error('department_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Footer --}}
            <div class="p-4 flex flex-wrap justify-end gap-2 items-center bg-white rounded-b-lg">
                <button type="submit" class="transition duration-100 bg-[#923534] text-white px-4 py-2 rounded hover:bg-[#7B2323] focus:outline-none focus:ring focus:ring-red-300">
                    {{ $updateMode ? 'Update' : 'Save' }}
                </button>
                <button type="button" wire:click="closeModal" class="transition duration-100 bg-[#666] text-white px-4 py-2 rounded hover:bg-zinc-600 focus:outline-none focus:ring focus:ring-gray-300">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
@endif




</div>

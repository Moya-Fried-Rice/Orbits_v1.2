<div class="bg-white">
    <!-- Notification -->
    <x-system-notification />

    <div class="p-5 pb-0 flex flex-wrap justify-between items-center">

        <!-- Filters and Search Bar Section -->
        <div class="flex flex-wrap gap-4 items-center justify-start w-full sm:w-auto">

            <!-- Search Bar -->
            <livewire:search-bar />

            <!-- Search course -->
            <livewire:search-courses />

            <!-- Search course -->
            <livewire:search-programs />

            <!-- Search course -->
            <livewire:search-faculties />

            <!-- Clear Button -->
            <x-clear-button />

        </div>

        <!-- Add Section Button -->
        <x-add-button add="Section" />

    </div>

    <!-- Section List -->
    <x-table :action="true">
        <x-slot name="header">

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="section"
                label="Section Name"/>

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="course_name"
                label="Course"/>

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="program_name"
                label="Programs"/>

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="faculty_name"
                label="Faculty"/>

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
            @if($sections->isEmpty())
            <tr>
                <td colspan="7" class="text-center py-4">No sections found.</td>
            </tr>
            @else
            @foreach ($sections as $section)
            <tr class="font-normal border border-[#DDD] text-[#666]-100 hover:bg-[#F8F8F8] transition-colors duration-100">
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $section->section }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $section->course->course_name }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $section->program->program_code }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">
                @if($section->faculty)
                    {{ $section->faculty->first_name }} {{ $section->faculty->last_name }}
                @else
                    No faculty assigned
                @endif
                </td>                
                <td class="py-2 whitespace-nowrap px-4">{{ $section->created_at->format('Y-m-d H:i') }}</td>
                <td class="py-2 whitespace-nowrap px-4">{{ $section->updated_at->format('Y-m-d H:i') }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">
                    <div class="flex items-center justify-end space-x-2">
                        <button wire:click="edit({{ $section->course_section_id }})">
                            <img src="{{ asset('assets/icons/edit.svg') }}" alt="Edit" class="hover:transform hover:rotate-12 bg-[#DDD] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                        </button>
                        <button wire:click="delete({{ $section->course_section_id }})">
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
        {{ $sections->links() }}
    </div>

{{-- Modal Delete --}}
<x-delete-modal label="section"/>

{{-- Modal Edit --}}
<x-edit-modal label="course section">

    <!-- Course Code -->
    <x-add-modal-data name="section" label="Section Code:">
        <input 
            class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
            type="text" 
            id="section" 
            wire:model="section">
    </x-add-modal-data>

    <!-- Faculty (Editable) -->
    <x-add-modal-data name="faculty_id" label="Faculty:">
        <select 
            class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200"
            id="faculty_id" 
            wire:model="faculty_id">
            <option value="">Select a faculty</option>
            @foreach ($this->getFaculties() as $faculty)
                <option value="{{ $faculty->faculty_id }}">{{ $faculty->first_name }} {{ $faculty->last_name }}</option>
            @endforeach
        </select>
    </x-add-modal-data>

</x-edit-modal>


{{-- Modal Add --}}
<x-add-modal label="section">

    <!-- Course ID -->
    <x-add-modal-data name="course_id" label="Course:">
        <select 
            class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200"
            id="course_id" 
            wire:model="course_id">
                <option value="">Select a course</option>
                @foreach ($this->getCourses() as $course)
                    <option value="{{ $course->course_id }}">{{ $course->course_name }}</option>
                @endforeach
        </select>
    </x-add-modal-data>

    <!-- Section -->
    <x-add-modal-data name="section" label="Section:">
        <input 
            class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
            type="text" 
            id="section" 
            wire:model="section">
    </x-add-modal-data>

    <!-- Faculty -->
    <x-add-modal-data name="faculty_id" label="Faculty:">
        <select 
            class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200"
            id="faculty_id" 
            wire:model="faculty_id">
                <option value="">Select a faculty</option>
                @foreach ($this->getFaculties() as $faculty)
                    <option value="{{ $faculty->faculty_id }}">{{ $faculty->first_name }} {{ $faculty->last_name }}</option>
                @endforeach
        </select>
    </x-add-modal-data>

    <!-- Program -->
    <x-add-modal-data name="program_id" label="Program:">
        <select 
            class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200"
            id="program_id" 
            wire:model="program_id">
                <option value="">Select a program</option>
                @foreach ($this->getPrograms() as $program)
                    <option value="{{ $program->program_id }}">{{ $program->program_name }}</option>
                @endforeach
        </select>
    </x-add-modal-data>

</x-add-modal>

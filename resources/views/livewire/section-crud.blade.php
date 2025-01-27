<div class="bg-white">
    <!-- Notification -->
    <x-system-notification />

    <div class="p-5 pb-0 flex flex-wrap justify-between items-center">

        <!-- Filters and Search Bar Section -->
        <div class="flex flex-wrap gap-4 items-center justify-start w-full sm:w-auto">

            <!-- Search bar -->
            <livewire:search-bar />

            <!-- Search course -->
            <livewire:search-programs />

            <!-- Clear Button -->
            <x-clear-button />

        </div>

        <!-- Add Section Button -->
        <x-add-button add="Section" />

    </div>

    <div class="py-5">
        <!-- Section List -->
        <x-table :action="true">
            <x-slot name="header">

                <x-table-header
                    sortField="{{ $sortField }}"
                    sortDirection="{{ $sortDirection }}"
                    data="section_code"
                    label="Section Code"/>
                    
                <x-table-header
                    sortField="{{ $sortField }}"
                    sortDirection="{{ $sortDirection }}"
                    data="program_name"
                    label="Program Code"/>

                <x-table-header
                    sortField="{{ $sortField }}"
                    sortDirection="{{ $sortDirection }}"
                    data="year_level"
                    label="Year Level"/>

                <x-table-header
                    sortField="{{ $sortField }}"
                    sortDirection="{{ $sortDirection }}"
                    data="section_number"
                    label="Section Number"/>

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
                    <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $section->section_code }}</td>
                    <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $section->program->program_code }}</td>
                    <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $this->ordinal($section->year_level) }} Year</td>
                    <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $section->section_number }}</td>
                    <td class="py-2 whitespace-nowrap px-4">
                        {{ $section->created_at ? $section->created_at->format('Y-m-d H:i') : 'N/A' }}
                    </td>
                    <td class="py-2 whitespace-nowrap px-4">
                        {{ $section->updated_at ? $section->updated_at->format('Y-m-d H:i') : 'N/A' }}
                    </td>
                    <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">
                        <div class="flex items-center justify-end space-x-2">
                            <a 
                                href="{{ route('section.courses', ['uuid' => $section->uuid]) }}" 
                                class="bg-[#F8F8F8] text-[#2A2723] px-3 py-1 text-sm transition duration-100 border hover:border-[#923534]"
                            >
                                View Courses
                            </a>
                            <button wire:click="delete({{ $section->section_id }})" class="w-8 h-8">
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
        <div class="p-5 pb-0">
            {{ $sections->links() }}
        </div>

    </div>

    {{-- Modal Delete --}}
    <x-delete-modal label="section"/>

    {{-- Modal Add --}}
    <x-add-modal label="section">

        <!-- Program -->
        <x-add-modal-data name="program_id" label="Program:">
            {{-- Not using component because doesnt work with live --}}
            <select 
                class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200"
                id="program_id" 
                wire:model.live="program_id">
                <option value="">Select a program</option>

                @foreach ($this->getDepartments() as $department)
                    <optgroup label="{{ $department->department_name }}"> 
                        @foreach ($department->program as $program) <!-- Assuming programs is a relationship -->
                            <option value="{{ $program->program_id }}">{{ $program->program_name }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select> 
        </x-add-modal-data>

        <div class="flex w-full gap-5">
            <!-- Year Level -->
            <x-add-modal-data name="year_level" label="Year Level:">
                <input 
                    class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
                    type="number" 
                    id="year_level" 
                    min="1"
                    max="15"
                    wire:model.live="year_level">
            </x-add-modal-data>

            <!-- Section Number -->
            <x-add-modal-data name="section_number" label="Section Number:">
                <input 
                    class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
                    type="number" 
                    id="section_number" 
                    min="1"
                    max="15"
                    wire:model.live="section_number">
            </x-add-modal-data>

            <x-add-modal-data name="section_code" label="Section Code:">
                <div class="px-4 w-full p-2">
                    {{ $section_output }}
                </div>
            </x-add-modal-data>
        </div>

    </x-add-modal>
</div>












{{-- <div class="bg-white">

    <x-system-notification />

    <div class="p-5 pb-0 flex flex-wrap justify-between items-center">

        <div class="flex flex-wrap gap-4 items-center justify-start w-full sm:w-auto">

            <livewire:search-bar />

            <livewire:search-courses />

            <livewire:search-programs />

            <livewire:search-faculties />

            <x-clear-button />

        </div>

        <x-add-button add="Section" />

    </div>

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

    <div class="p-5">
        {{ $sections->links() }}
    </div>

<x-delete-modal label="section"/>

<x-edit-modal label="course section">

    <x-add-modal-data name="section" label="Section Code:">
        <input 
            class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
            type="text" 
            id="section" 
            wire:model="section">
    </x-add-modal-data>

    <x-add-modal-data name="faculty_id" label="Faculty:">

        <x-select-faculty />
    
    </x-add-modal-data>

</x-edit-modal>


<x-add-modal label="section">

    <x-add-modal-data name="course_id" label="Course:">
       
        <x-select-course />

    </x-add-modal-data>

    <x-add-modal-data name="program_id" label="Program:">
           
        <x-select-program />

    </x-add-modal-data>

    <x-add-modal-data name="section" label="Section:">
        <input 
            class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
            type="text" 
            id="section" 
            wire:model="section">
    </x-add-modal-data>

    <x-add-modal-data name="faculty_id" label="Faculty:">
        
        <x-select-faculty />

    </x-add-modal-data>

</x-add-modal> --}}

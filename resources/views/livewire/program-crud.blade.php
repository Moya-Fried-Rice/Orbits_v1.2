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
    
        <!-- Add Program Button -->
        <x-add-button add="Program" />
    
    </div>
    
    <!-- Program List -->
    <x-table :action="true">
        <x-slot name="header">

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="program_code"
                label="Program Code"/>

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="program_name"
                label="Program Name"/>

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="abbreviation"
                label="Abbreviation"/>

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="program_description"
                label="Description"/>

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="department_name"
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
            @if($programs->isEmpty())
            <tr>
                <td colspan="7" class="text-center py-4">No programs found.</td>
            </tr>
            @else
            @foreach ($programs as $program)
            <tr class="font-normal border border-[#DDD] text-[#666]-100 hover:bg-[#F8F8F8] transition-colors duration-100">
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $program->program_code }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-64">{{ $program->program_name }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $program->abbreviation }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $program->program_description }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $program->department->department_code ?? 'N/A' }}</td>
                <td class="py-2 whitespace-nowrap px-4">{{ $program->created_at->format('Y-m-d H:i') }}</td>
                <td class="py-2 whitespace-nowrap px-4">{{ $program->updated_at->format('Y-m-d H:i') }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">
                    <div class="flex items-center justify-end space-x-2">
                        <a 
                            href="{{ route('program.courses', ['uuid' => $program->uuid]) }}" 
                            class="bg-[#F8F8F8] text-[#2A2723] px-3 py-1 text-sm transition duration-100 border hover:border-[#923534]"
                        >
                            View Courses
                        </a>
                        <button wire:click="delete({{ $program->program_id }})" class="w-8 h-8">
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
        {{ $programs->links() }}
    </div>

</div>

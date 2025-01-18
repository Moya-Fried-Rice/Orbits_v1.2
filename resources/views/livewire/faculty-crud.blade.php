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
    
        <!-- Add Faculty Button -->
        <x-add-button add="Faculty" />
    
    </div>
    
    <!-- Faculty List -->
    <x-table :action="true">
        <x-slot name="header">

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="profile_image"
                label="Profile"/>
                
            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="first_name"
                label="First Name"/>

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="last_name"
                label="Last Name"/>

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="department_name"
                label="Department"/>

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="phone_number"
                label="Phone Number"/>

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
            @if($faculties->isEmpty())
            <tr>
                <td colspan="8" class="text-center py-4">No faculty found.</td>
            </tr>
            @else
            @foreach ($faculties as $faculty)
            <tr class="font-normal border border-[#DDD] text-[#666]-100 hover:bg-[#F8F8F8] transition-colors duration-100">
                <td class="py-2 whitespace-nowrap px-4">
                    <img src="{{ $faculty->profile_image }}" class="w-8 h-8 rounded-full" alt="Profile">                      
                </td>                
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $faculty->first_name }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $faculty->last_name }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $faculty->department->department_name }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $faculty->phone_number }}</td>
                <td class="py-2 whitespace-nowrap px-4">{{ $faculty->created_at->format('Y-m-d H:i') }}</td>
                <td class="py-2 whitespace-nowrap px-4">{{ $faculty->updated_at->format('Y-m-d H:i') }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">
                    <div class="flex items-center justify-end space-x-2">
                        <button wire:click="edit({{ $faculty->faculty_id }})">
                            <img src="{{ asset('assets/icons/edit.svg') }}" alt="Edit" class="hover:transform hover:rotate-12 bg-[#DDD] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                        </button>
                        <button wire:click="delete({{ $faculty->faculty_id }})">
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
        {{ $faculties->links() }}
    </div>

</div>

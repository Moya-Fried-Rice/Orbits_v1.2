<div class="bg-white">

    <x-system-notification />
    
    <div class="p-5 pb-0 flex flex-wrap justify-between items-center">

        <!-- Filters and Search Bar Section -->
        <div class="flex flex-wrap gap-4 items-center justify-start w-full sm:w-auto">
    
            <!-- Search Bar -->
            <livewire:search-bar />
    
            <!-- Search Program -->
            <livewire:search-programs />
    
            <!-- Clear Button -->
            <x-clear-button />
    
        </div>
    
        <!-- Add Student Button -->
        <x-add-button add="Student" />
    
    </div>
    
    <!-- Student List -->
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
                data="program_name"
                label="Program"/>

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
            @if($students->isEmpty())
            <tr>
                <td colspan="8" class="text-center py-4">No students found.</td>
            </tr>
            @else
            @foreach ($students as $student)
            <tr class="font-normal border border-[#DDD] text-[#666]-100 hover:bg-[#F8F8F8] transition-colors duration-100">
                <td class="py-2 whitespace-nowrap px-4">
                    <div class="relative">
                        <!-- Loading Spinner (Initially visible) -->
                        <div class="spinner flex text-xs" id="spinner-{{ $student->student_id }}">
                            Loading...
                        </div> 
                        
                        <!-- Profile Image (Initially hidden) -->
                        <img 
                            id="profile-img-{{ $student->student_id }}"
                            
                            onload="
                            document.getElementById('spinner-{{ $student->student_id }}').style.display='none'; 
                            this.style.display='block';" 

                            onerror="
                            this.style.display='none'; 
                            document.getElementById('spinner-{{ $student->student_id }}').style.display='none';"

                            src="{{ $student->profile_image }}" 
                            alt="Profile Image" 
                            class="hidden w-8 h-8 rounded-full object-cover">
                    </div>                    
                </td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $student->first_name }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $student->last_name }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $student->program->program_code }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $student->phone_number }}</td>
                <td class="py-2 whitespace-nowrap px-4">{{ $student->created_at->format('Y-m-d H:i') }}</td>
                <td class="py-2 whitespace-nowrap px-4">{{ $student->updated_at->format('Y-m-d H:i') }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">
                    <div class="flex items-center justify-end space-x-2">
                        <button wire:click="edit({{ $student->student_id }})">
                            <img src="{{ asset('assets/icons/edit.svg') }}" alt="Edit" class="hover:transform hover:rotate-12 bg-[#DDD] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                        </button>
                        <button wire:click="delete({{ $student->student_id }})">
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
        {{ $students->links() }}
    </div>

</div>

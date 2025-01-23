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
                    <img src="{{ asset('storage/' . $student->profile_image) }}" class="object-cover w-8 h-8 rounded-full" alt="Profile">                      
                </td>                
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $student->first_name }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $student->last_name }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $student->program->program_code }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $student->phone_number }}</td>
                <td class="py-2 whitespace-nowrap px-4">{{ $student->created_at->format('Y-m-d H:i') }}</td>
                <td class="py-2 whitespace-nowrap px-4">{{ $student->updated_at->format('Y-m-d H:i') }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">
                    <div class="flex items-center justify-end space-x-2">
                        <a 
                            href="{{ route('student.update', ['uuid' => $student->uuid]) }}" 
                            class="bg-[#F8F8F8] text-[#2A2723] px-3 py-1 text-sm transition duration-100 border hover:border-[#923534]"
                        >
                            View Profile
                        </a>
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

    <!-- Modal Add -->
<x-add-modal label="student">

    <!-- First Name -->
    <div class="flex w-full gap-5">
        <x-add-modal-data name="first_name" label="First Name:">
            <input 
                class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200" 
                type="text" 
                id="first_name" 
                wire:model="first_name">
        </x-add-modal-data>

        <!-- Last Name -->
        <x-add-modal-data name="last_name" label="Last Name:">
            <input 
                class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200" 
                type="text" 
                id="last_name" 
                wire:model="last_name">
        </x-add-modal-data>
    </div>
    
    <!-- Program -->
    <x-add-modal-data name="program_id" label="Program:">

        <x-select-program/>

    </x-add-modal-data>

    <!-- Profile Image -->
    <x-add-modal-data name="profile_image" label="Profile Image:">
        <input 
            class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200" 
            type="file" 
            id="profile_image" 
            accept="image/jpeg, image/png, image/jpg, image/gif, image/webp"
            wire:model="profile_image">
    </x-add-modal-data>

    <br>

    <!-- Email -->
    <x-add-modal-data name="email" label="Email:">
        <input 
            class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200" 
            type="text" 
            id="email" 
            wire:model="email">
    </x-add-modal-data>

    <!-- Phone Number -->
    <x-add-modal-data name="phone_number" label="Phone Number:">
        <input 
            class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200" 
            type="text" 
            id="phone_number" 
            wire:model="phone_number">
    </x-add-modal-data>

</x-add-modal>


</div>



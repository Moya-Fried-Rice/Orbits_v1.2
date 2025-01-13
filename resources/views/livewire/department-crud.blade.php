<div class="bg-white">
    <!-- Notification -->
    <x-system-notification />
    
    <div class="p-5 pb-0 flex flex-wrap justify-between items-center">

        <!-- Filters and Search Bar Section -->
        <div class="flex flex-wrap gap-4 items-center justify-start w-full sm:w-auto">
    
            <!-- Search Bar -->
            <livewire:search-bar />
    
            <!-- Clear Button -->
            <x-clear-button />
    
        </div>
    
        <!-- Add Department Button -->
        <x-add-button add="Department" />
    
    </div>
    
    <!-- Department List -->
    <x-table :action="true">
        <x-slot name="header">

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="department_code"
                label="Department Code"/>

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="department_name"
                label="Department Name"/>

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="department_description"
                label="Department Description"/>

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
            @if($departments->isEmpty())
            <tr>
                <td colspan="5" class="text-center py-4">No departments found.</td>
            </tr>
            @else
            @foreach ($departments as $department)
            <tr class="font-normal border border-[#DDD] text-[#666]-100 hover:bg-[#F8F8F8] transition-colors duration-100">
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $department->department_code }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $department->department_name }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $department->department_description }}</td>
                <td class="py-2 whitespace-nowrap px-4">{{ $department->created_at->format('Y-m-d H:i') }}</td>
                <td class="py-2 whitespace-nowrap px-4">{{ $department->updated_at->format('Y-m-d H:i') }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">
                    <div class="flex items-center justify-end space-x-2">
                        <button wire:click="edit({{ $department->department_id }})">
                            <img src="{{ asset('assets/icons/edit.svg') }}" alt="Edit" class="hover:transform hover:rotate-12 bg-[#DDD] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                        </button>
                        <button wire:click="delete({{ $department->department_id }})">
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
        {{ $departments->links() }}
    </div>

    {{-- Modal Delete --}}
    <x-delete-modal label="department"/>

    {{-- Modal Edit --}}
    <x-edit-modal label="department">

        <!-- Department Code -->
        <x-add-modal-data name="department_code" label="Department Code:">
            <input 
                class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
                type="text" 
                id="department_code" 
                wire:model="department_code">

            @error('department_code') 
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </x-add-modal-data>

        <!-- Department Name -->
        <x-add-modal-data name="department_name" label="Department Name:">
            <input 
                class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
                type="text" 
                id="department_name" 
                wire:model="department_name">

            @error('department_name') 
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </x-add-modal-data>

        <!-- Department Description -->
        <x-add-modal-data name="department_description" label="Department Description:">
            <textarea 
                class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
                id="department_description" 
                rows="4"
                wire:model="department_description"></textarea>
    
            @error('department_description') 
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </x-add-modal-data>

    </x-edit-modal>

    {{-- Modal Add --}}
    <x-add-modal label="department">

        <!-- Department Code -->
        <x-add-modal-data name="department_code" label="Department Code:">
            <input 
                class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
                type="text" 
                id="department_code" 
                wire:model="department_code">

            @error('department_code') 
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </x-add-modal-data>

        <!-- Department Name -->
        <x-add-modal-data name="department_name" label="Department Name:">
            <input 
                class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
                type="text" 
                id="department_name" 
                wire:model="department_name">

            @error('department_name') 
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </x-add-modal-data>

        <!-- Department Description -->
        <x-add-modal-data name="department_description" label="Department Description:">
            <textarea 
                class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
                id="department_description" 
                rows="4"
                wire:model="department_description"></textarea>
    
            @error('department_description') 
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </x-add-modal-data>

    </x-add-modal>
</div>

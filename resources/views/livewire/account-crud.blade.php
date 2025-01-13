<div class="bg-white">
    <!-- Notification -->
    <x-system-notification />
    
    <div class="p-5 pb-0 flex flex-wrap justify-between items-center">

        <!-- Filters and Search Bar Section -->
        <div class="flex flex-wrap gap-4 items-center justify-start w-full sm:w-auto">
    
            <!-- Search Bar -->
            <livewire:search-bar />

            <x-filter-role />
    
            <!-- Clear Button -->
            <div class="flex flex-cols w-full sm:w-auto">
                <button wire:click="clearFilters" class="w-full sm:w-auto px-4 py-2 rounded hover:bg-[#F8F8F8] transition duration-100">
                    <i class="fa fa-eraser"></i> Clear
                </button>
            </div>
    
        </div>
    
    </div>
    
    <!-- Account List -->
    <x-table :action="true">
        <x-slot name="header">

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="name"
                label="Name"/>

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="email"
                label="Email"/>

            <x-table-header
                sortField="{{ $sortField }}"
                sortDirection="{{ $sortDirection }}"
                data="role"
                label="Role"/>

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
            @if($accounts->isEmpty())
            <tr>
                <td colspan="5" class="text-center py-4">No accounts found.</td>
            </tr>
            @else
            @foreach ($accounts as $account)
            <tr class="font-normal border border-[#DDD] text-[#666]-100 hover:bg-[#F8F8F8] transition-colors duration-100">
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $account->name }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $account->email }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $account->role }}</td>
                <td class="py-2 whitespace-nowrap px-4">{{ $account->created_at->format('Y-m-d H:i') }}</td>
                <td class="py-2 whitespace-nowrap px-4">{{ $account->updated_at->format('Y-m-d H:i') }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">
                    <div class="flex items-center space-x-2">
                        <button wire:click="edit({{ $account->user_id }})">
                            <img src="{{ asset('assets/icons/edit.svg') }}" alt="Edit" class="hover:transform hover:rotate-12 bg-[#DDD] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
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
        {{ $accounts->links() }}
    </div>

    {{-- Modal Edit --}}
    <x-edit-modal label="account">

        <!-- Email -->
        <x-add-modal-data name="email" label="Email:">
            <input 
                class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
                type="email" 
                id="email" 
                wire:model="email">

            @error('email') 
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </x-add-modal-data>

        <!-- Role -->
        <x-add-modal-data name="role" label="Role:">
            <select 
                class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
                id="role" 
                wire:model="role">
                <option value="">Select a role</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>

            @error('role') 
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </x-add-modal-data>

        <!-- Password -->
        <x-add-modal-data name="password" label="Password:">
            <input 
                class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 border hover:border-[#923534] transition-all duration-200" 
                type="password" 
                id="password" 
                wire:model="password">

            @error('password') 
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </x-add-modal-data>

    </x-edit-modal>
</div>

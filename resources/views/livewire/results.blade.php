<div class="bg-white">
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
    
    </div>
    
    <!-- Faculty List -->
    <div class="p-5">
        <x-table :action="true">
            <x-slot name="header">

                <x-table-header
                    :allowSort="false"
                    sortField="{{ $sortField }}"
                    sortDirection="{{ $sortDirection }}"
                    data="profile_image"
                    label="Profile"/>
                    
                <x-table-header
                    sortField="{{ $sortField }}"
                    sortDirection="{{ $sortDirection }}"
                    data="full_name"
                    label="Faculty Name"/>

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
                        <img src="{{ asset('storage/' . $faculty->profile_image) }}" class="object-cover w-8 h-8 rounded-full" alt="Profile">                      
                    </td>                
                    <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $faculty->faculty_name }}</td>
                    <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $faculty->department->department_name }}</td>
                    <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $faculty->phone_number }}</td>
                    <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">
                        <div class="flex items-center justify-end space-x-2">
                            <a 
                                href="{{ route('summary', ['uuid' => $faculty->uuid]) }}" 
                                class="bg-[#F8F8F8] text-[#2A2723] px-3 py-1 text-sm transition duration-100 border hover:border-[#923534]"
                            >
                                View Results
                            </a>
                        </div>
                    </td>
                </tr>            
                @endforeach
                @endif
            </x-slot>
        </x-table>
    
        <!-- Pagination -->
        <div class="p-5 pb-0">
            {{ $faculties->links() }}
        </div>
    
    </div>
</div>

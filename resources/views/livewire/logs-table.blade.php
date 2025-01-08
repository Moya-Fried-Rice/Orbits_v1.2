<div class="bg-white pb-5">
    <!-- Logs Table -->
    <div class="overflow-x-auto">
        <x-table :action="false">
            <x-slot name="header">
                <x-table-header
                    sortField="{{ $sortField }}"
                    sortDirection="{{ $sortDirection }}"
                    data="event"
                    label="Event Type"/>

                <x-table-header
                    sortField="{{ $sortField }}"
                    sortDirection="{{ $sortDirection }}"
                    data="properties"
                    label="Status"/>

                <x-table-header
                    sortField="{{ $sortField }}"
                    sortDirection="{{ $sortDirection }}"
                    data="description"
                    label="Description"/>

                <x-table-header
                    sortField="{{ $sortField }}"
                    sortDirection="{{ $sortDirection }}"
                    data="causer_id"
                    label="Caused By"/>

                <x-table-header
                    sortField="{{ $sortField }}"
                    sortDirection="{{ $sortDirection }}"
                    data="properties"
                    label="Details"/>

                <x-table-header
                    sortField="{{ $sortField }}"
                    sortDirection="{{ $sortDirection }}"
                    data="created_at"
                    label="Time"/>
            </x-slot>

            <x-slot name="body">
                @if($logs->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center py-4">No activity logs found.</td>
                    </tr>
                @else
                    @foreach ($logs as $log)
                        <tr class="font-normal border border-[#DDD] text-[#666]-100 hover:bg-[#F8F8F8] transition-colors duration-100">
                            <!-- Event Type -->
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-2 
                                @if($log->event == 'Error') 
                                    bg-red-50 
                                @elseif($log->event == 'Store') 
                                    bg-green-50 
                                @elseif($log->event == 'Delete') 
                                    bg-red-50  
                                @elseif($log->event == 'Update') 
                                    bg-yellow-50 
                                @elseif($log->event == 'Restore') 
                                    bg-blue-50
                                @endif
                                border-l-4
                                @if(isset($log->properties['status']))
                                    @if($log->properties['status'] === 'error') 
                                        border-red-200
                                    @elseif($log->properties['status'] === 'success') 
                                        border-green-200
                                    @endif
                                @endif">
                                {{ strtoupper($log->event) }}
                            </td>


                            <!-- Status -->
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-2">
                                {{ ucfirst($log->properties['status']) }}
                            </td>                            

                            <!-- Event-based Description -->
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-2">
                                {{ $log->description }}
                            </td>

                            <!-- Caused By -->
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-2">
                                {{ $log->causedBy ? $log->causedBy->name : 'N/A' }}
                            </td>

                            {{-- Details --}}
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-md overflow-auto">
                                @switch($log->event)
                                    @case('Store')
                                        @if(isset($log->properties['message']))
                                            Message: {{ $log->properties['message'] ?? 'N/A' }}
                                        @else
                                            New Entry Created: {{ $log->properties['name'] ?? 'N/A' }}
                                        @endif
                                    @break

                                    @case('Update')
                                    @if(isset($log->properties['changes']))
                                        @if(is_string($log->properties['changes']))
                                            <p>{{ $log->properties['changes'] }}</p>
                                        @else
                                            @foreach($log->properties['changes'] as $field => $change)
                                                @if($field === 'department_id')
                                                    <!-- If it's department_id, use getDepartment to display department name -->
                                                    Department: 
                                                    {{ $this->getDepartment($change['old']) ?? 'N/A' }} 
                                                    <i class="fa fa-arrow-right"></i>
                                                    {{ $this->getDepartment($change['new']) ?? 'N/A' }}
                                                @else
                                                    {{ ucfirst(str_replace('_', ' ', $field)) }}: 
                                                    {{ $change['old'] ?? 'N/A' }} 
                                                    <i class="fa fa-arrow-right"></i>
                                                    {{ $change['new'] ?? 'N/A' }}
                                                @endif
                                            @endforeach
                                        @endif
                                    @endif
                                        
                                        @if(isset($log->properties['message']))
                                            Message: {{ $log->properties['message'] ?? 'N/A' }}
                                        @endif
                                    @break

                                    @case('Delete')
                                        Delete Attempt/Deleted Data: {{ $log->properties['name'] ?? 'N/A' }}
                                    @break

                                    @case('Restore')
                                        Restored Data: {{ $log->properties['name'] ?? 'N/A' }}
                                    @break

                                    @case('Error')
                                        Error Message: {{ $log->properties['message'] ?? 'N/A' }}
                                    @break

                                    @default
                                        <pre>{{ json_encode($log->properties, JSON_PRETTY_PRINT) }}</pre>
                                @endswitch
                            </td>

                            <!-- Created At -->
                            <td class="py-2 whitespace-nowrap px-4 truncate">
                                {{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d H:i') }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </x-slot>
        </x-table>
    </div>
</div>

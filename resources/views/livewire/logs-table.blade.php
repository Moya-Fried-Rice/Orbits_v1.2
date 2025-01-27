<div class="bg-white h-full overflow-x-auto">
    <!-- Logs Table -->
    <div class="py-5">
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
                        <tr class="font-normal border border-[#DDD] text-[#666]-100 transition-all duration-100
                                @if(isset($log->properties['status']))
                                    @if($log->properties['status'] === 'error') 
                                        bg-red-50 hover:bg-red-100
                                    @elseif($log->properties['status'] === 'success') 
                                        bg-green-50 hover:bg-green-100
                                    @endif
                                @endif">
                            <!-- Event Type -->
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-2 ">
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
                                {{ $log->causer ? $log->causer->name : 'N/A' }}
                            </td>

                            {{-- Details --}}
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-md overflow-auto">
                               
                                        <pre>{{ json_encode($log->properties, JSON_PRETTY_PRINT) }}</pre>
                              
                            </td>

                          <!-- Created At -->
                            <td class="py-2 whitespace-nowrap px-4 truncate">
                                {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </x-slot>
        </x-table>
    </div>
</div>

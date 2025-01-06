<div class="bg-white pb-5">
    <!-- Logs Table -->
    <x-table :action="false">
        <x-slot name="header">
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
                    <td colspan="4" class="text-center py-4">No activity logs found.</td>
                </tr>
            @else
                @foreach ($logs as $log)
                    <tr class="font-normal border border-[#DDD] text-[#666]-100 hover:bg-[#F8F8F8] transition-colors duration-100">
                        <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $log->description }}</td>
                        <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $log->causedBy ? $log->causedBy->name : 'N/A' }}</td>
                        <td class="py-2 whitespace-nowrap px-4 truncate max-w-sm">
                            <pre>{{ json_encode($log->properties, JSON_PRETTY_PRINT) }}</pre>
                        </td>
                        <td class="py-2 whitespace-nowrap px-4">{{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            @endif
        </x-slot>
    </x-table>
</div>

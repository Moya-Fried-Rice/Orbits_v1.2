@props(['sortField', 'sortDirection', 'data', 'label', 'allowSort' => true])

<th 
    @if($allowSort) 
        wire:click="sortBy('{{ $data }}')" 
        class="items-center border border-[#DDD] text-left py-2 px-4 whitespace-nowrap font-light cursor-pointer hover:bg-blue-50 transition-colors duration-100"
    @else 
        class="items-center border border-[#DDD] text-left py-2 px-4 whitespace-nowrap font-light transition-colors duration-100"
    @endif
>
    <div class="flex items-center gap-2 justify-between" style="user-select: none;">
        <span class="text-[#2A2723]">
            {{ $label }}
        </span>
        @if($allowSort)
            <span class="ml-1 text-xs text-[#2A2723]">
                @if($sortField === $data)
                    <i class="fas {{ $sortDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down' }}"></i>
                @else
                    <i class="fas fa-sort"></i>
                @endif
            </span>
        @endif
    </div>
</th>

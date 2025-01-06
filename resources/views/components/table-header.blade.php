@props(['sortField', 'sortDirection', 'data', 'label'])

<th wire:click="sortBy('{{ $data }}')" class="items-center border border-[#DDD] text-left py-2 px-4 whitespace-nowrap font-light cursor-pointer hover:bg-blue-50 transition-colors duration-100">
    <div class="flex items-center gap-2 justify-between" style="user-select: none;">
        {{ $label }} <!-- Assuming $data is a column name, make it more readable -->
        <span class="ml-1 text-xs text-[#666]">
            @if($sortField === $data) <!-- Directly compare $sortField with $data -->
                <i class="fas {{ $sortDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down' }}"></i>
            @else
                <i class="fas fa-sort"></i>
            @endif
        </span>
    </div>
</th>

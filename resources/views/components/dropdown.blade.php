@props(['active', 'icon'])

@php
// Determine the CSS classes based on the 'active' prop
$classes = ($active ?? false)
    ? 'nav-btn bg-[#EFEFEF] group nav-btn-hover cursor-pointer'
    : 'nav-btn group nav-btn-hover cursor-pointer';
@endphp

<div x-data="{ showData: {{ $active ? 'true' : 'false' }} }">
    <!-- Trigger element for the dropdown -->
    <div @click="showData = !showData" {{ $attributes->merge(['class' => $classes]) }} style="margin-bottom: 0;">
        <!-- Icon for the dropdown -->
        <img src="{{ $icon }}" alt="{{ $icon }} Icon" class="icon">
        <!-- Text for the dropdown trigger -->
        <span class="nav-text" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
            {{ $trigger }}
        </span>
        <!-- Chevron icon indicating dropdown state -->
        <i x-show="showSidebar" class="fas fa-chevron-right mr-2 transition-transform duration-100" :class="{'transform rotate-90': showData, 'transform rotate-0': !showData}"></i>
    </div>

    <!-- Dropdown content -->
    <div 
        x-show="showData" 
        x-transition:enter="transition-all cubic-bezier(.74,.52,.25,1) duration-500" 
        x-transition:enter-start="max-h-0" 
        x-transition:enter-end="max-h-screen" 
        x-transition:leave="transition-all cubic-bezier(.74,.52,.25,1) duration-500" 
        x-transition:leave-start="max-h-screen" 
        x-transition:leave-end="max-h-0" 
        class="bg-[#F8F8F8] overflow-hidden p-0">
        {{ $content }}
    </div>
</div>

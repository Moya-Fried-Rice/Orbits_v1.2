@props(['active', 'icon', 'label'])

@php
// Determine the CSS classes to apply based on the 'active' prop
$classes = ($active ?? false)
            ? 'nav-btn bg-[#EFEFEF] group nav-btn-hover cursor-pointer'
            : 'nav-btn group nav-btn-hover cursor-pointer';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <!-- Icon image -->
    <img src="{{ $icon }}" alt="Icon" class="icon">

    <!-- Navigation text with dynamic width based on 'showSidebar' -->
    <span class="nav-text" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
        {{ $label }}
    </span>
    <x-tooltip label="{{ $label }}" />
</a>
@props(['active', 'icon', 'label'])

<span class="bg-white py-1 px-4 shadow-sm border border-[#D4D4D4] font-normal pointer-events-none absolute left-10 group-hover:opacity-100 opacity-0 transition-all duration-200 transform group-hover:left-16 flex items-center"
    x-bind:class="{'hidden': showSidebar, 'block': !showSidebar}">
    <i class="fa fa-message mr-2"></i>{{ $label }}
</span>
@props(['count', 'label', 'icon'])

<div class="bg-white rounded-lg p-6 flex flex-1 justify-between items-center relative overflow-hidden">
    <div class="relative z-10">
        <h3 class="text-4xl font-semibold">{{ $count }}</h3>
        <p class="text-xl">{{ $label }}</p>
    </div>
    <div class="absolute -right-8 h-full flex items-center z-0">
        <img src="{{ $icon }}" class="border-8 bg-[#EFEFEF] opacity-50 rounded-full p-10 w-36 h-36" alt="Icon">
    </div>
</div>

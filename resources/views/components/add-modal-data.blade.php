@props(['label', 'name'])

<div class="w-full">
    <label for="{{ $name }}" class="block text-md pb-2 text-[#666]">{{ $label }}</label>
        {{ $slot }}
</div>
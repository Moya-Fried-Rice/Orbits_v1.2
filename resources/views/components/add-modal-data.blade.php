@props(['label', 'name'])

<div>
    <label for="{{ $name }}" class="block text-md pb-2 text-[#666]">{{ $label }}</label>
        {{ $slot }}
</div>
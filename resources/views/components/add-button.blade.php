@props(['add'])

<div class="w-full sm:w-auto mt-4 sm:mt-0">
    <button wire:click="add" class="w-full sm:w-auto bg-[#923534] text-white py-2 px-4 rounded flex items-center gap-1 transition duration-100 hover:transform hover:scale-105">
        <img src="{{ asset('assets/icons/add.svg') }}" alt="Add">{{ $add }}
    </button>
</div>
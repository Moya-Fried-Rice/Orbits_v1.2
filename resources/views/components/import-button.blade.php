@props(['import'])

<div class="w-full md:w-auto mt-4 md:mt-0">
    <button wire:click="import" class="w-full md:w-auto border border-[#923534] text-[#923534] hover:bg-[#923534] hover:text-white py-2 px-4 rounded flex items-center gap-1 transition duration-100 hover:transform hover:scale-105">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
        </svg>Import CSV/Excel
    </button>
</div>
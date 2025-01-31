@props(['label'])

<div x-data="{ modalOpen: @entangle('showDeleteConfirmation') }">
    <div 
    x-show="modalOpen"
    x-transition:enter="transition-opacity duration-300 ease-out"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity duration-300 ease-in"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    style="transition: all 100ms ease;"
    class="fixed inset-0 bg-black bg-opacity-20 overflow-y-auto flex justify-center items-center z-30" 
    wire:click.self="cancelDelete">

        <div x-show="modalOpen" 
        x-transition:enter="transition transform"
        x-transition:enter-start="translate-y-[-40px] opacity-0" 
        x-transition:enter-end="translate-y-0 opacity-100"
        style="transition: all 300ms cubic-bezier(0, 1.13, 0.53, 1.13);"
        class="bg-[#F8F8F8] rounded-lg w-full max-w-lg sm:max-w-md mx-auto relative">

            {{-- Header --}}
            <div class="p-4 flex justify-center font-semibold items-center bg-white font-TT rounded-t-lg relative">
                <h3 class="text-lg sm:text-xl">Delete Confirmation</h3>
            </div>

            {{-- Body --}}
            <div class="flex flex-col items-center px-6 py-4 text-center">
                <img src="{{ asset('assets/icons/error.svg') }}" class="w-20 h-20 mb-4" alt="Warning">
                <p class="text-gray-700 text-sm sm:text-base">Are you sure you want to delete this {{ $label }}?</p>
                <p class="text-xs text-gray-500 mt-2 sm:text-sm">This action can be undone.</p>
            </div>

            {{-- Footer --}}
            <div class="p-4 flex flex-wrap justify-center gap-4 bg-white rounded-b-lg">
                <button wire:click="confirmDelete" class="transition duration-100 bg-[#923534] text-white px-4 py-2 rounded hover:bg-[#7B2323] focus:outline-none focus:ring focus:ring-red-300">
                    Yes, Delete
                </button>
                <button wire:click="cancelDelete" class="transition duration-100 bg-[#666] text-white px-4 py-2 rounded hover:bg-zinc-600 focus:outline-none focus:ring focus:ring-gray-300">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
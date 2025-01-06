@props(['label', 'modal'])

@if ($modal)
    <div class="fixed inset-0 bg-black bg-opacity-20 overflow-y-auto flex justify-center items-center z-30" wire:click="cancelDelete">
        <div class="bg-[#F8F8F8] rounded-lg w-full max-w-lg sm:max-w-md mx-auto relative">

            {{-- Header --}}
            <div class="p-4 flex justify-center font-semibold items-center bg-white font-TT rounded-t-lg relative">
                {{-- <button wire:click="cancelDelete" class="font-thin text-lg absolute left-4">
                    <i class="fa fa-times"></i>
                </button> --}}
                <h3 class="text-lg sm:text-xl">Delete Confirmation</h3>
            </div>

            {{-- Body --}}
            <div class="flex flex-col items-center px-6 py-4 text-center">
                <img src="{{ asset('assets/icons/error.svg') }}" class="w-20 h-20 mb-4" alt="Warning">
                <p class="text-gray-700 text-sm sm:text-base">Are you sure you want to delete this {{ $label }}?</p>
                <p class="text-xs text-gray-500 mt-2 sm:text-sm">This action cannot be undone.</p>
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
@endif
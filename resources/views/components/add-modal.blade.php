@props(['modal', 'confirmation', 'label'])

@if ($modal)
<div class="fixed inset-0 bg-black bg-opacity-20 overflow-y-auto flex justify-center items-center z-30" wire:click.self="closeAdd">
    <div class="bg-[#F8F8F8] rounded-lg w-full max-w-lg sm:max-w-md md:max-w-xl lg:max-w-2xl mx-auto relative">

        {{-- Header --}}
        <div class="p-4 flex justify-center font-semibold items-center bg-white font-TT rounded-t-lg relative">
            Add {{ ucwords($label) }}
        </div>

        <form wire:submit.prevent="storeConfirmation">
            
            <div class="space-y-4 py-4 max-h-[70vh] px-6 overflow-y-auto">
                {{ $slot }}
            </div>

            <!-- Submit Button -->
            <div class="p-4 flex flex-wrap justify-end gap-2 items-center bg-white rounded-b-lg">
                <button type="submit" class="transition duration-100 bg-[#923534] text-white px-4 py-2 rounded hover:bg-[#7B2323] focus:outline-none focus:ring focus:ring-red-300">
                    Add {{ $label }}
                </button>

                <button type="button" wire:click="closeAdd" class="transition duration-100 bg-[#666] text-white px-4 py-2 rounded hover:bg-zinc-600 focus:outline-none focus:ring focus:ring-gray-300">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- Modal confirmation Add --}}
@if ($confirmation)
<div class="fixed inset-0 bg-black bg-opacity-20 overflow-y-auto flex justify-center items-center z-30" wire:click.self="closeAdd">
    <div class="bg-[#F8F8F8] rounded-lg w-full max-w-lg sm:max-w-md mx-auto relative">

        {{-- Header --}}
        <div class="p-4 flex justify-center font-semibold items-center bg-white font-TT rounded-t-lg relative">
            <h3 class="text-lg sm:text-xl">Confirm Add</h3>
        </div>

        {{-- Body --}}
        <div class="flex flex-col items-center px-6 py-4 text-center">
            <img src="{{ asset('assets/icons/info.svg') }}" class="w-20 h-20 mb-4" alt="Confirm">
            <p class="text-gray-700 text-sm sm:text-base">Are you sure you want to add this new {{ $label }}?</p>
            <p class="text-xs text-gray-500 mt-2 sm:text-sm">This action will create new data in the system.</p>
        </div>

        {{-- Footer --}}
        <div class="p-4 flex flex-wrap justify-center gap-4 bg-white rounded-b-lg">
            <button wire:click="confirmStore" class="transition duration-100 bg-[#923534] text-white px-4 py-2 rounded hover:bg-[#7B2323] focus:outline-none focus:ring focus:ring-red-300">
                Yes, Add {{ $label }}
            </button>
            <button wire:click="cancelStore" class="transition duration-100 bg-[#666] text-white px-4 py-2 rounded hover:bg-zinc-600 focus:outline-none focus:ring focus:ring-gray-300">
                Cancel
            </button>
        </div>
    </div>
</div>

@endif

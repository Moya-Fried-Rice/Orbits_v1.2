@props(['label', 'fields'])

<div x-data="{ modalOpen: @entangle('showImportForm'), confirmationOpen: @entangle('showImportConfirmation') }">

    <div 
    x-show="modalOpen || confirmationOpen"
    x-transition:enter="transition-opacity duration-300 ease-out"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity duration-300 ease-in"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    style="transition: all 100ms ease;"
    class="fixed inset-0 bg-black bg-opacity-20 overflow-y-auto flex justify-center items-center z-30" 
    wire:click.self="closeImport">

        <!-- Modal Content -->
        <div x-show="modalOpen"
        x-transition:enter="transition transform" 
        x-transition:enter-start="translate-y-[-40px] opacity-0" 
        x-transition:enter-end="translate-y-0 opacity-100"
        style="transition: all 300ms cubic-bezier(0, 1.13, 0.53, 1.13);"
        class="inset-0 bg-[#F8F8F8] rounded-lg w-full max-w-lg sm:max-w-md md:max-w-xl lg:max-w-2xl mx-auto relative">

            {{-- Header --}}
            <div class="p-4 flex justify-center font-semibold items-center bg-white font-TT rounded-t-lg relative">
                Import {{ ucwords($label) }} List
            </div>

            <div class="space-y-4 py-4 max-h-[70vh] px-6 overflow-y-auto">
                <div>
                    <p class="text-[#2A2723] mb-2">Supported file formats:</p>
                    <ul class="text-[#666] list-disc pl-4 space-y-1">
                        <li>Excel files (.xlsx, .xls)</li>
                        <li>CSV files (.csv)</li>
                    </ul>
                </div>

                <div>
                    <p class="text-[#2A2723] mb-2">Required columns in your file:</p>
                    <div class="bg-[#F8F8F8] p-3 rounded border border-[#DDD]">
                        <code class="text-[#666]">
                            Order: {{ $fields }}
                        </code>
                    </div>
                </div>
            </div>

            <form wire:submit.prevent="importConfirmation">
                <div class="space-y-4 py-4 max-h-[70vh] px-6 overflow-y-auto">
                    <div class="w-full">
                        <label for="file" class="block text-md pb-2 text-[#666]">Upload File:</label>
                            <input 
                            type="file" 
                            wire:model="file" 
                            accept=".csv,.xlsx,.xls" 
                            class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200">
                        @error('file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="p-4 flex flex-wrap justify-end gap-2 items-center bg-white rounded-b-lg">
                    <button type="submit" class="transition duration-100 bg-[#923534] text-white px-4 py-2 rounded hover:bg-[#7B2323] focus:outline-none focus:ring focus:ring-red-300">
                        Import {{ ucwords($label) }}
                    </button>

                    <button type="button" wire:click="closeImport" class="transition duration-100 bg-[#666] text-white px-4 py-2 rounded hover:bg-zinc-600 focus:outline-none focus:ring focus:ring-gray-300">
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        <!-- Confirmation Modal -->
        <div x-show="confirmationOpen" 
        x-transition:enter="transition transform" 
        x-transition:enter-start="translate-y-[-40px] opacity-0" 
        x-transition:enter-end="translate-y-0 opacity-100"
        style="transition: all 300ms cubic-bezier(0, 1.13, 0.53, 1.13);"
        class="inset-0 bg-[#F8F8F8] rounded-lg w-full max-w-lg sm:max-w-md mx-auto relative">

            {{-- Header --}}
            <div class="p-4 flex justify-center font-semibold items-center bg-white font-TT rounded-t-lg relative">
                <h3 class="text-lg sm:text-xl">Confirm Import</h3>
            </div>
    
            {{-- Body --}}
            <div class="flex flex-col items-center px-6 py-4 text-center">
                <img src="{{ asset('assets/icons/info.svg') }}" class="w-20 h-20 mb-4" alt="Confirm">
                <p class="text-gray-700 text-sm sm:text-base">Are you sure you want to import these {{ $label }}?</p>
                <p class="text-xs text-gray-500 mt-2 sm:text-sm">This action will bulk import student data into the system.</p>
            </div>
    
            {{-- Footer --}}
            <div class="p-4 flex flex-wrap justify-center gap-4 bg-white rounded-b-lg">
                <button wire:click="confirmImport" class="transition duration-100 bg-[#923534] text-white px-4 py-2 rounded hover:bg-[#7B2323] focus:outline-none focus:ring focus:ring-red-300">
                    Yes, Import {{ ucwords($label) }}
                </button>
                <button wire:click="cancelImport" class="transition duration-100 bg-[#666] text-white px-4 py-2 rounded hover:bg-zinc-600 focus:outline-none focus:ring focus:ring-gray-300">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

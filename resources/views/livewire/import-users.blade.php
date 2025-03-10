<!-- System Notification -->
<x-system-notification />

<div>
    <!-- Import Button -->
    <div class="inline-block" x-data="{ showModal: false, showConfirmation: false }">
        <button x-on:click="showModal = true" wire:click="clearMessage" class="flex items-center gap-2 border border-[#923534] text-[#923534] hover:bg-[#923534] hover:text-white px-4 py-2 rounded transition duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
            </svg>
            Import Excel/CSV
        </button>

        <!-- Import Form Modal -->
        <div x-show="showModal" class="fixed inset-0 overflow-y-auto z-[60]" x-cloak>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="showModal" 
                    x-transition:enter="ease-out duration-300" 
                    x-transition:enter-start="opacity-0" 
                    x-transition:enter-end="opacity-100" 
                    x-transition:leave="ease-in duration-200" 
                    x-transition:leave-start="opacity-100" 
                    x-transition:leave-end="opacity-0" 
                    class="fixed inset-0 bg-gray-500 bg-opacity-75">
                </div>

                <div x-show="showModal" 
                    x-transition:enter="ease-out duration-300" 
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                    x-transition:leave="ease-in duration-200" 
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                    class="relative transform bg-white rounded-lg shadow-xl transition-all max-w-lg w-full mx-auto">
                    
                    <div class="bg-white p-6">
                        <div class="flex justify-between items-center border-b border-[#DDD] pb-3 mb-4">
                            <h3 class="text-lg font-medium text-[#2A2723]">Import {{ ucfirst($userType) }}s</h3>
                            <button x-on:click="showModal = false" wire:click="closeImport" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="space-y-6 mb-6">
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
                                        @if($userType === 'student')
                                        Order: First Name, Last Name, Email, Phone Number, Program ID
                                        @else
                                        Order: First Name, Last Name, Email, Phone Number, Department ID
                                        @endif
                                    </code>
                                </div>
                            </div>

                            <x-add-modal-data name="file" label="Upload File:">
                                <input 
                                    type="file" 
                                    wire:model="file" 
                                    accept=".csv,.xlsx,.xls" 
                                    class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200">
                                @error('file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </x-add-modal-data>
                        </div>

                        <div class="border-t border-[#DDD] pt-3 flex justify-end gap-3">
                            <button x-on:click="showModal = false" wire:click="closeImport" class="px-4 bg-white w-20 p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200">
                                Cancel
                            </button>
                            <button wire:click="importConfirmation" x-on:click="showModal = false; showConfirmation = true" class="px-4 bg-[#923534] text-white w-20 p-2 border rounded border-[#923534] focus:ring focus:ring-blue-300 hover:bg-[#923534]/80 transition-all duration-200">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Import Confirmation Modal -->
        <div x-show="showConfirmation" class="fixed inset-0 overflow-y-auto z-[60]" x-cloak>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="showConfirmation" 
                    x-transition:enter="ease-out duration-300" 
                    x-transition:enter-start="opacity-0" 
                    x-transition:enter-end="opacity-100" 
                    x-transition:leave="ease-in duration-200" 
                    x-transition:leave-start="opacity-100" 
                    x-transition:leave-end="opacity-0" 
                    class="fixed inset-0 bg-gray-500 bg-opacity-75">
                </div>

                <div x-show="showConfirmation" 
                    x-transition:enter="ease-out duration-300" 
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                    x-transition:leave="ease-in duration-200" 
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                    class="relative transform bg-white rounded-lg shadow-xl transition-all max-w-lg w-full mx-auto">
                    
                    <div class="bg-white p-6">
                        <div class="border-b border-[#DDD] pb-3 mb-4">
                            <h3 class="text-lg font-medium text-[#2A2723]">Confirm Import</h3>
                            <p class="mt-2 text-[#666]">Are you sure you want to import these {{ $userType }}s? This action cannot be undone.</p>
                        </div>

                        <div class="border-t border-[#DDD] pt-3 flex justify-end gap-3">
                            <button x-on:click="showConfirmation = false" wire:click="cancelImport" class="px-4 bg-white w-20 p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200">
                                Cancel
                            </button>
                            <button wire:click="confirmImport" x-on:click="showConfirmation = false" class="px-4 bg-[#923534] text-white w-20 p-2 border rounded border-[#923534] focus:ring focus:ring-blue-300 hover:bg-[#923534]/80 transition-all duration-200">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

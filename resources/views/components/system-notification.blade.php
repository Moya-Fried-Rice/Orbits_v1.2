@if (session()->has('success'))
    <!-- Success Notification -->
    <div class="bg-green-100 border-l-4 border-[#87C26A] text-[#87C26A] p-4 flex justify-between items-center" role="alert">
        <div class="flex gap-2">
            <img src="{{ asset('assets/icons/success.svg') }}" alt="Success">
            {{ session('success') }}
        </div>
        <button type="button" class="text-[#87C26A] mr-5" wire:click="clearMessage">
            <i class="fa fa-times"></i>
        </button>
    </div>
    <div class="animate-bounce absolute top-5 z-50" x-show="scrollPosition >= 110" x-transition.opacity>
        <div class="border-2 border-[#87C26A] rotate-[45deg]  m-5 mt-2 text-[#87C26A] text-xl bg-green-100 flex items-center justify-center rounded-full rounded-tl-none">
            <img src="{{ asset('assets/icons/success.svg') }}" class="w-6 h-6 m-1 rotate-[-45deg]" alt="Success">
        </div>
    </div>
@elseif(session()->has('deleted'))
    <!-- Deleted Notification -->
    <div class="bg-green-100 border-l-4 border-[#87C26A] text-[#87C26A] p-4 flex justify-between items-center" role="alert">
        <div class="flex gap-2">
            <img src="{{ asset('assets/icons/success.svg') }}" alt="Success">
            {{ session('deleted') }}
            <button 
                type="button" 
                class="underline font-semibold"
                wire:click="undoDelete">
                Undo
            </button>
        </div>
        <button type="button" class="text-[#87C26A] mr-5" wire:click="clearMessage">
            <i class="fa fa-times"></i>
        </button>
    </div>
    <div class="animate-bounce absolute top-5 z-50" x-show="scrollPosition >= 110" x-transition.opacity>
        <div class="border-2 border-[#87C26A] rotate-[45deg]  m-5 mt-2 text-[#87C26A] text-xl bg-green-100 flex items-center justify-center rounded-full rounded-tl-none">
            <img src="{{ asset('assets/icons/success.svg') }}" class="w-6 h-6 m-1 rotate-[-45deg]" alt="Success">
        </div>
    </div>
@elseif (session()->has('error'))
    <!-- Error Notification -->
    <div class="bg-red-100 border-l-4 border-[#923534] text-[#923534] p-4 flex justify-between items-center" role="alert">
        <div class="flex gap-2">
            <img src="{{ asset('assets/icons/error.svg') }}" alt="Error">
            {{ session('error') }}
        </div>
        <button type="button" class="text-[#923534] mr-5" wire:click="clearMessage">
            <i class="fa fa-times"></i>
        </button>
    </div>
    <div class="animate-bounce absolute top-5 z-50" x-show="scrollPosition >= 110" x-transition.opacity>
        <div class="border-2 border-[#923534] rotate-[45deg] m-5 mt-2 text-[#923534] text-xl bg-red-100 flex items-center justify-center rounded-full rounded-tl-none">
            <img src="{{ asset('assets/icons/error.svg') }}" class="w-6 h-6 m-1 rotate-[-45deg]" alt="Error">
        </div>
    </div>
@elseif (session()->has('info'))
    <!-- Info Notification -->
    <div class="bg-blue-100 border-l-4 border-[#4A90E2] text-[#4A90E2] p-4 flex justify-between items-center" role="alert">
        <div class="flex gap-2">
            <img src="{{ asset('assets/icons/info.svg') }}" alt="Info">
            {{ session('info') }}
        </div>
        <button type="button" class="text-[#4A90E2] mr-5" wire:click="clearMessage">
            <i class="fa fa-times"></i>
        </button>
    </div>
    <div class="animate-bounce absolute top-5 z-50" x-show="scrollPosition >= 110" x-transition.opacity>
        <div class="border-2 border-[#4A90E2] rotate-[45deg] m-5 mt-2 text-[#4A90E2] text-xl bg-blue-100 flex items-center justify-center rounded-full rounded-tl-none">
            <img src="{{ asset('assets/icons/info.svg') }}" class="w-6 h-6 m-1 rotate-[-45deg]" alt="Info">
        </div>
    </div>
@endif

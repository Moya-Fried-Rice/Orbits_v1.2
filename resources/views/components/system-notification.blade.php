@if (session()->has('success'))
<div class="bg-green-100 border-l-4 border-[#87C26A] text-[#87C26A] p-4 flex justify-between items-center" role="alert">
    <div class="flex gap-2">
        <img src="{{ asset('assets/icons/success.svg') }}" alt="Success">
        {{ session('success') }}
    </div>
    <button type="button" class="text-[#87C26A] mr-5" wire:click="clearMessage">
        <i class="fa fa-times"></i>
    </button>
</div>
@elseif(session()->has('deleted'))
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
@elseif (session()->has('error'))
<div class="bg-red-100 border-l-4 border-[#923534] text-[#923534] p-4 flex justify-between items-center" role="alert">
    <div class="flex gap-2">
        <img src="{{ asset('assets/icons/error.svg') }}" alt="Error">
        {{ session('error') }}
    </div>
    <button type="button" class="text-[#923534] mr-5" wire:click="clearMessage">
        <i class="fa fa-times"></i>
    </button>
</div>
@elseif (session()->has('info'))
<div class="bg-blue-100 border-l-4 border-[#4A90E2] text-[#4A90E2] p-4 flex justify-between items-center" role="alert">
    <div class="flex gap-2">
        <img src="{{ asset('assets/icons/info.svg') }}" alt="Info">
        {{ session('info') }}
    </div>
    <button type="button" class="text-[#4A90E2] mr-5" wire:click="clearMessage">
        <i class="fa fa-times"></i>
    </button>
</div>
@endif
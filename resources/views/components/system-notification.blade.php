@php
    $sessionTypes = [
        'success' => ['bg' => 'bg-green-100', 'border' => 'border-[#87C26A]', 'text' => 'text-[#87C26A]', 'icon' => 'success.svg'],
        'deleted' => ['bg' => 'bg-green-100', 'border' => 'border-[#87C26A]', 'text' => 'text-[#87C26A]', 'icon' => 'success.svg', 'extra' => '<button type="button" class="underline font-semibold" wire:click="undoDelete">Undo</button>'],
        'error' => ['bg' => 'bg-red-100', 'border' => 'border-[#923534]', 'text' => 'text-[#923534]', 'icon' => 'error.svg'],
        'info' => ['bg' => 'bg-blue-100', 'border' => 'border-[#4A90E2]', 'text' => 'text-[#4A90E2]', 'icon' => 'info.svg']
    ];
@endphp

@foreach ($sessionTypes as $key => $attributes)
    @if (session()->has($key))
        <!-- Notification -->
        <div class="{{ $attributes['bg'] }} border-l-4 {{ $attributes['border'] }} {{ $attributes['text'] }} p-4 flex justify-between items-center" role="alert">
            <div class="flex gap-2">
                <img src="{{ asset('assets/icons/' . $attributes['icon']) }}" alt="{{ ucfirst($key) }}">
                {{ session($key) }}
                {!! $attributes['extra'] ?? '' !!}
            </div>
            <button type="button" class="{{ $attributes['text'] }} mr-5" wire:click="clearMessage()">
                <i class="fa fa-times"></i>
            </button>
        </div>
        <div class="animate-bounce absolute top-5 z-50" x-show="scrollPosition >= 110" x-transition.opacity>
            <div class="border-2 {{ $attributes['border'] }} rotate-[45deg] m-5 mt-2 {{ $attributes['text'] }} text-xl {{ $attributes['bg'] }} flex items-center justify-center rounded-full rounded-tl-none">
                <img src="{{ asset('assets/icons/' . $attributes['icon']) }}" class="w-6 h-6 m-1 rotate-[-45deg]" alt="{{ ucfirst($key) }}">
            </div>
        </div>
    @endif
@endforeach

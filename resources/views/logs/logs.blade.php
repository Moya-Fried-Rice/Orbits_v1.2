{{-- Layout Template --}}
@extends('layouts.master')

@section('title')

    <title>Orbits | Activity Logs</title>
    
@endsection

{{-- Content --}}
@section('content')

<div class="font-TT mb-2 flex justify-between items-center gap-2 hover:opacity-100 transition-all duration-100">

    <div class="opacity-50 hidden md:block">
    System Logs
    </div>

    <div class="flex justify-between items-center gap-2">
        <a href="{{ route('dashboard') }}" class="opacity-50 hover:opacity-100 transition-all duration-100">
            Home
        </a>
        <span class="text-xs opacity-50"><i class="fa-solid fa-chevron-right"></i></span>
        <a href="{{ route('logs') }}" class="opacity-50 hover:opacity-100 transition-all duration-100">
            Logs
        </a>
    </div>
</div>

    {{-- Livewire Component --}}
    @livewire('logs-table')

@endsection

{{-- Scripts --}}
@section('scripts')

    {{-- Scripts Here --}}
    
@endsection
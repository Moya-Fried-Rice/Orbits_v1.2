@extends('layouts.master')

@section('title')

    <title>Orbits | Evaluate Faculty</title>

@endsection

@section('content')

    <div class="font-TT mb-2 flex justify-between items-center gap-2 hover:opacity-100 transition-all duration-100">

        <div class="opacity-50 hidden md:block">
        Evaluate
        </div>

        <div class="flex justify-between items-center gap-2">
            <a href="{{ route('dashboard') }}" class="opacity-50 hover:opacity-100 transition-all duration-100">
                Home
            </a>
            <span class="text-xs opacity-50"><i class="fa-solid fa-chevron-right"></i></span>
            <a href="{{ route('evaluate') }}" class="opacity-50 hover:opacity-100 transition-all duration-100">
                Evaluate
            </a>
        </div>
    </div>
        
    @livewire('evaluate')

@endsection

@section('scripts')

@endsection

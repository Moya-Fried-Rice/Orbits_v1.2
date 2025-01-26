{{-- Layout Template --}}
@extends('layouts.master')

@section('title')

    <title>Orbits | Faculty Profile</title>

@endsection
{{-- Content --}}
@section('content')

<div class="font-TT mb-2 flex justify-between items-center gap-2 hover:opacity-100 transition-all duration-100">

    <div class="opacity-50 hidden md:block">
    Faculty Profile
    </div>

    <div class="flex justify-between items-center gap-2">
        <a href="{{ route('dashboard') }}" class="opacity-50 hover:opacity-100 transition-all duration-100">
            Home
        </a>
        <span class="text-xs opacity-50"><i class="fa-solid fa-chevron-right"></i></span>
        <a href="{{ route('faculties') }}" class="opacity-50 hover:opacity-100 transition-all duration-100">
            Faculties
        </a>
        <span class="text-xs opacity-50"><i class="fa-solid fa-chevron-right"></i></span>
        <a href="{{ route('faculty.profile', ['uuid' => $uuid]) }}" class="opacity-50 hover:opacity-100 transition-all duration-100">
            Profile
        </a>
    </div>
</div>

    {{-- Livewire Component --}}
    <livewire:faculty-profile-crud :uuid="$uuid" />

@endsection

{{-- Scripts --}}
@section('scripts')

    {{-- Scripts Here --}}
    
@endsection

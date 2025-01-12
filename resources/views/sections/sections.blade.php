{{-- Layout Template --}}
@extends('layouts.master')

@section('title')

    <title>Orbits | Section Management</title>

@endsection
{{-- Content --}}
@section('content')

    {{-- Livewire Component --}}
    @livewire('section-crud')

@endsection

{{-- Scripts --}}
@section('scripts')

    {{-- Scripts Here --}}
    
@endsection

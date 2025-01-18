{{-- Layout Template --}}
@extends('layouts.master')

@section('title')

    <title>Orbits | Faculty Management</title>

@endsection
{{-- Content --}}
@section('content')

    {{-- Livewire Component --}}
    @livewire('faculty-crud')

@endsection

{{-- Scripts --}}
@section('scripts')

    {{-- Scripts Here --}}
    
@endsection

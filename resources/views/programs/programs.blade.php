{{-- Layout Template --}}
@extends('layouts.master')

@section('title')

    <title>Orbits | Program Management</title>

@endsection
{{-- Content --}}
@section('content')

    {{-- Livewire Component --}}
    @livewire('program-crud')

@endsection

{{-- Scripts --}}
@section('scripts')

    {{-- Scripts Here --}}
    
@endsection

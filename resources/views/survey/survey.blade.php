{{-- Layout Template --}}
@extends('layouts.master')

@section('title')

    <title>Orbits | Survey Management</title>

@endsection
{{-- Content --}}
@section('content')

    {{-- Livewire Component --}}
    @livewire('survey-crud')

@endsection

{{-- Scripts --}}
@section('scripts')

    {{-- Scripts Here --}}
    
@endsection

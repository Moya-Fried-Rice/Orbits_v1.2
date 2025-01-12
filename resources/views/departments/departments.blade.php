{{-- Layout Template --}}
@extends('layouts.master')

@section('title')

    <title>Orbits | Department Management</title>

@endsection
{{-- Content --}}
@section('content')

    {{-- Livewire Component --}}
    @livewire('department-crud')

@endsection

{{-- Scripts --}}
@section('scripts')

    {{-- Scripts Here --}}
    
@endsection

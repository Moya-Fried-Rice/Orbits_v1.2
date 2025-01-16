{{-- Layout Template --}}
@extends('layouts.master')

@section('title')

    <title>Orbits | Student Management</title>

@endsection
{{-- Content --}}
@section('content')

    {{-- Livewire Component --}}
    @livewire('student-crud')

@endsection

{{-- Scripts --}}
@section('scripts')

    {{-- Scripts Here --}}
    
@endsection

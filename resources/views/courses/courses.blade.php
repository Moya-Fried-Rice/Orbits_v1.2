{{-- Layout Template --}}
@extends('layouts.master')

@section('title')

    <title>Orbits | Course Management</title>

@endsection
{{-- Content --}}
@section('content')

    {{-- Livewire Component --}}
    @livewire('course-crud')

@endsection

{{-- Scripts --}}
@section('scripts')

    {{-- Scripts Here --}}
    
@endsection

{{-- Layout Template --}}
@extends('layouts.master')

@section('title')

    <title>Orbits | Activity Logs</title>
    
@endsection

{{-- Content --}}
@section('content')

    {{-- Livewire Component --}}
    @livewire('logs-table')

@endsection

{{-- Scripts --}}
@section('scripts')

    {{-- Scripts Here --}}
    
@endsection
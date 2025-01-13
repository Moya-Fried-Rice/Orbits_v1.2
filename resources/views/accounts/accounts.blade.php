{{-- Layout Template --}}
@extends('layouts.master')

@section('title')

    <title>Orbits | Account Management</title>

@endsection
{{-- Content --}}
@section('content')

    {{-- Livewire Component --}}
    @livewire('account-crud')

@endsection

{{-- Scripts --}}
@section('scripts')

    {{-- Scripts Here --}}
    
@endsection

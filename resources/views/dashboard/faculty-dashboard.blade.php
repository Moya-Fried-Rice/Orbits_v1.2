@extends('layouts.master')

@section('title')

    <title>Orbits | Faculty Dashboard</title>
    
@endsection

@section('content')
@include('components.verify-email-message') <!-- Include the email verification message -->

<div class="font-TT mb-2 flex justify-between items-center gap-2 hover:opacity-100 transition-all duration-100">

    <div class="opacity-50 hidden md:block">
    Faculty Dashboard
    </div>

    <div class="flex justify-between items-center gap-2">
        <a href="{{ route('dashboard') }}" class="opacity-50 hover:opacity-100 transition-all duration-100">
            Home
        </a>
    </div>
</div>

faculty


@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>





@endsection

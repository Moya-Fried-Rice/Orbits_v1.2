@extends('layouts.master')

@section('content')

<div class="font-TT mb-2 flex justify-between items-center gap-2 hover:opacity-100 transition-all duration-100">

    <div class="opacity-50 hidden md:block">
    Evaluation Settings
    </div>

    <div class="flex justify-between items-center gap-2">
        <a href="{{ route('dashboard') }}" class="opacity-50 hover:opacity-100 transition-all duration-100">
            Home
        </a>
        <span class="text-xs opacity-50"><i class="fa-solid fa-chevron-right"></i></span>
        <a href="{{ route('evaluation') }}" class="opacity-50 hover:opacity-100 transition-all duration-100">
            Evaluation Settings
        </a>
    </div>
</div>
    
@endsection

@section('scripts')

@endsection

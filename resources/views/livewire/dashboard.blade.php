@extends('components.layouts.app')

@section('content')

<div class="space-y-6">

    <!-- Evaluation Section -->
    <div class="bg-white rounded-lg p-6">
        Evaluation
    </div>

    <!-- Cards Section -->
    <div class="grid grid-rows-1 gap-5 
    sm:grid-cols-2 
    md:grid-cols-2 
    lg:grid-cols-3 
    xl:grid-cols-6">

        <x-card 
            count="{{ \App\Models\Student::count() }}" 
            label="Students" 
            icon="{{ asset('assets/icons/student.svg') }}" 
        />

        <x-card 
            count="{{ \App\Models\Faculty::count() }}" 
            label="Faculty" 
            icon="{{ asset('assets/icons/faculty.svg') }}" 
        />

        <x-card 
            count="{{ \App\Models\Course::count() }}" 
            label="Courses" 
            icon="{{ asset('assets/icons/course.svg') }}" 
        />

        <x-card 
            count="{{ \App\Models\Program::count() }}" 
            label="Programs" 
            icon="{{ asset('assets/icons/program.svg') }}" 
        />

        <x-card 
            count="{{ \App\Models\CourseSection::count() }}" 
            label="Sections" 
            icon="{{ asset('assets/icons/section.svg') }}" 
        />

        <x-card 
            count="{{ \App\Models\Student::count() }}" 
            label="Users" 
            icon="{{ asset('assets/icons/account.svg') }}" 
        />

    </div>

    <!-- Progress Section -->
    <div class="grid gap-5 
    sm:grid-cols-2 
    md:grid-cols-2 
    lg:grid-cols-3 
    xl:grid-cols-4">

        <div class="bg-white rounded-lg p-6
        sm:col-span-2
        md:col-span-2
        lg:col-span-1
        xl:col-span-1">

        </div>

        <div class="bg-white rounded-lg p-6
        sm:col-span-2
        md:col-span-2
        lg:col-span-2
        xl:col-span-2">

        </div>

        <div class="bg-white rounded-lg p-6
        sm:col-span-2
        md:col-span-2
        lg:col-span-3 
        xl:col-span-1 ">
        
        </div>

    </div>

    <!-- Monitoring Section -->
    <div class="grid gap-5 
    sm:grid-cols-1 
    md:grid-cols-1 
    lg:grid-cols-2 
    xl:grid-cols-2">

        <div class="bg-white rounded-lg p-6
        sm:col-span-1
        md:col-span-1
        lg:col-span-2
        xl:col-span-1">

        </div>

        <div class="bg-white rounded-lg p-6
        sm:col-span-1
        md:col-span-1
        lg:col-span-2
        xl:col-span-1">

        </div>

    </div>

</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

@endsection

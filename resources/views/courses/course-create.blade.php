@extends('layouts.master')

@section('content')
 
<div class="bg-white p-12 font-TT font-light">
    <form action="{{ route('courses.store') }}" method="POST" class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        @csrf

        <!-- Course Name -->
        <div class="col-span-1">
            <label for="course_name" class="block text-gray-700 font-medium mb-2">Course Name</label>
            <input 
                type="text" 
                name="course_name" 
                id="course_name" 
                value="{{ old('course_name') }}" 
                class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" 
                required>
        </div>

        <!-- Course Code -->
        <div class="col-span-1">
            <label for="course_code" class="block text-gray-700 font-medium mb-2">Course Code</label>
            <input 
                type="text" 
                name="course_code" 
                id="course_code" 
                value="{{ old('course_code') }}" 
                class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" 
                required>
        </div>

        <!-- Course Description -->
        <div class="col-span-1 sm:col-span-2">
            <label for="course_description" class="block text-gray-700 font-medium mb-2">Course Description</label>
            <textarea 
                name="course_description" 
                id="course_description" 
                rows="4"
                class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" 
                required>{{ old('course_description') }}</textarea>
        </div>

        <!-- Department -->
        <div class="col-span-1">
            <label for="department_id" class="block text-gray-700 font-medium mb-2">Department</label>
            <select 
                name="department_id" 
                id="department_id" 
                class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" 
                required>
                <option value="">Select a Department</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->department_id }}" 
                        {{ old('department_id') == $department->department_id ? 'selected' : '' }}>
                        {{ $department->department_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <div class="col-span-1 sm:col-span-2 text-right">
            <button 
                type="submit" 
                class="bg-[#923534] text-white px-5 py-2.5 rounded btn btn-primary mb-3">
                Create Course
            </button>
        </div>
    </form>
</div>


@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
@endsection

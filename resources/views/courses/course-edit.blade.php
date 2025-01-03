@extends('layouts.master')

@section('content')
<div class="space-y-2">
    <div class="bg-white p-6 font-TT font-light space-y-2">
        <div class="flex justify-between items-center">
            <h1 class="font-silka text-3xl font-black">{{ $course->course_code }} - {{ $course->course_name }}</h1>
        </div>
        <div class="flex gap-2">
            <img src="{{ asset('assets/icons/survey.svg') }}" alt="Description">
            <p>{{ $course->course_description }}</p>
        </div>
        <div class="flex gap-2">
            <img src="{{ asset('assets/icons/department.svg') }}" alt="Department">
            <p>{{ $course->department->department_name }}</p>
        </div>
    </div>

    <div class="bg-white p-6 font-TT font-light">
        <form action="{{ route('courses.update', $course->course_id) }}" method="POST" class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            @csrf
            @method('PUT')
    
            <!-- Course Name -->
            <div class="col-span-1">
                <label for="course_name" class="block text-gray-700 font-medium mb-2">Course Name</label>
                <input 
                    type="text" 
                    name="course_name" 
                    id="course_name" 
                    value="{{ old('course_name', $course->course_name) }}" 
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
                    value="{{ old('course_code', $course->course_code) }}" 
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
                    required>{{ old('course_description', $course->course_description) }}</textarea>
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
                            {{ $course->department_id == $department->department_id ? 'selected' : '' }}>
                            {{ $department->department_name }}
                        </option>
                    @endforeach
                </select>
            </div>
    
            <div class="col-span-1 sm:col-span-2 text-right space-x-2">
                <!-- Return Button -->
                <a href="{{ url()->previous() }}" class="bg-gray-200 text-black px-5 py-2.5 rounded btn btn-primary">
                    Cancel
                </a>
                 <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="bg-[#923534] text-white px-5 py-2.5 rounded btn btn-primary">
                    Update Course
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
@endsection

@extends('layouts.master')

@section('content')

    <div class="bg-white p-6 font-TT font-light">
        <div class="flex justify-between items-center p-2">
            <div>
                Showing {{ $courses->count() }} courses
            </div>
            <div>
                <a href="{{ route('courses.create') }}" class="bg-[#923534] text-white px-5 py-2.5 rounded flex gap-1 btn btn-primary mb-3">
                <img src="{{ asset('assets/icons/add.svg') }}" alt="">Course
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="table table-bordered font-TT w-full">
                <thead>
                    <tr class="uppercase font-normal bg-[#F8F8F8] text-black">
                        <th class="border border-[#DDD] text-left py-2.5 px-4 whitespace-nowrap w-1/12 font-light">Course Code</th>
                        <th class="border border-[#DDD] text-left py-2.5 px-4 whitespace-nowrap w-1/12 font-light">Course Name</th>
                        <th class="border border-[#DDD] text-left py-2.5 px-4 whitespace-nowrap w-auto font-light">Course Description</th>
                        <th class="border border-[#DDD] text-left py-2.5 px-4 whitespace-nowrap w-1/12 font-light">Department</th>
                        <th class="border border-[#DDD] text-left py-2.5 px-4 whitespace-nowrap w-1/12 font-light">Date Created</th>
                        <th class="border border-[#DDD] text-left py-2.5 px-4 whitespace-nowrap w-1/12 font-light">Date Modified</th>
                        <th class="border border-[#DDD] text-left py-2.5 px-4 whitespace-nowrap w-28 font-light">Actions</th>      
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr class="font-normal border border-[#DDD] text-[#666]-100 hover:bg-[#F8F8F8] transition-colors duration-100">
                            <td class="py-2.5 px-4 whitespace-nowrap">{{ $course->course_code }}</td>
                            <td class="py-2.5 px-4 whitespace-nowrap">{{ $course->course_name }}</td>
                            <td class="py-2.5 px-4 whitespace-nowrap truncate max-w-xs">{{ $course->course_description }}</td>
                            <td class="py-2.5 px-4 whitespace-nowrap">{{ $course->department->department_code }}</td>
                            <td class="py-2.5 px-4 whitespace-nowrap">{{ $course->created_at }}</td>
                            <td class="py-2.5 px-4 whitespace-nowrap">{{ $course->updated_at }}</td>
                            <td class="py-2.5 px-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('courses.edit', ['course' => $course->course_id]) }}" class="flex items-center">
                                        <img src="{{ asset('assets/icons/edit.svg') }}" alt="Edit" class="bg-[#DDD] p-1.5 w-8 h-8 rounded">
                                    </a>
                                    <form action="{{ route('courses.destroy', $course->course_id) }}" method="POST" class="flex items-center" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex items-center">
                                            <img src="{{ asset('assets/icons/delete.svg') }}" alt="Delete" class="bg-[#666] p-1.5 w-8 h-8 rounded">
                                        </button>
                                    </form>
                                </div>                                              
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
@endsection

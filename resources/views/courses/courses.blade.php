@extends('layouts.master')

@section('content')

    @if(session('success'))
        <div id="success-message" class="absolute right-0 top-0 px-4 py-2 m-2 bg-green-200 text-black opacity-50 flex items-center justify-between space-x-4">
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('success-message').remove()" class="ml-4 text-black px-2 py-1">
                ✕
            </button>
        </div>
    @endif

    <div class="bg-white font-TT font-light rounded-lg">
            <div class="text-xl flex items-center space-x-2 p-6 pb-0">
                <img src="{{ asset('assets/icons/course.svg') }}" alt="Course">
                <div>
                    Course Management
                </div>
            </div>
            <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center p-6 pb-0 space-y-4 xl:space-y-0">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('courses.index') }}" class="flex flex-col font-TT w-full xl:w-auto">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-4">
                         <!-- Search by Code -->
                         <div>
                            <input class="w-full px-4 py-2 border border-[#DDD] rounded appearance-none" type="text" name="search_code" value="{{ old('search_code', $searchCode) }}" placeholder="Search by Code" />
                        </div>

                        <!-- Search by Name -->
                        <div>
                            <input class="w-full px-4 py-2 border border-[#DDD] rounded appearance-none" type="text" name="search_name" value="{{ old('search_name', $searchName) }}" placeholder="Search by Name" />
                        </div>
                        
                        <!-- Filter by Department -->
                        <div>
                            <select class="w-full px-4 py-2 border border-[#DDD] rounded appearance-none" name="department_id">
                                <option value="">Search by Department</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->department_id }}" {{ old('department_id', $departmentId) == $department->department_id ? 'selected' : '' }}>
                                        {{ $department->department_code }}
                                    </option>
                                @endforeach
                            </select>                    
                        </div>
                    
                        <!-- Submit and Reset Buttons -->
                        <div class="flex items-center space-x-4">
                            <button type="submit" class="flex items-center">
                                <i class="fa fa-filter" aria-hidden="true"></i> Filter
                            </button>
                            
                            <a href="{{ route('courses.index') }}" class="flex items-center">
                                <i class="fa fa-eraser"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>
            
                <!-- Add Course Button -->
                <div class="flex justify-center xl:justify-end w-full xl:w-auto">
                    <a href="{{ route('courses.create') }}" class="bg-[#923534] text-white py-2 px-4 rounded flex items-center gap-1">
                        <img src="{{ asset('assets/icons/add.svg') }}" alt="Add">Course
                    </a>
                </div>
            </div>
            

        <div class="overflow-x-auto p-6 pb-0">
            <table class="table table-bordered font-TT w-full">
                <thead>
                    <tr class="uppercase font-normal bg-[#F8F8F8] text-black">
                        <!-- Course Code -->
                        <th class="border border-[#DDD] text-left py-2.5 px-4 whitespace-nowrap w-1/12 font-light hover:bg-blue-50 transition-colors duration-100">
                            <a href="{{ route('courses.index', [
                                'sort_by' => 'course_code',
                                'sort_order' => $sortOrder === 'asc' ? 'desc' : 'asc',
                                'search_name' => $searchName,
                                'search_code' => $searchCode,
                                'department_id' => $departmentId
                            ]) }}" class="flex items-center w-full h-full">
                                Course Code
                            </a>
                        </th>
                        
                        <!-- Course Name -->
                        <th class="border border-[#DDD] text-left py-2.5 px-4 whitespace-nowrap w-1/12 font-light hover:bg-blue-50 transition-colors duration-100">
                            <a href="{{ route('courses.index', [
                                'sort_by' => 'course_name',
                                'sort_order' => $sortOrder === 'asc' ? 'desc' : 'asc',
                                'search_name' => $searchName,
                                'search_code' => $searchCode,
                                'department_id' => $departmentId
                            ]) }}" class="flex items-center w-full h-full">
                                Course Name
                            </a>
                        </th>
                        
                        <!-- Course Description -->
                        <th class="border border-[#DDD] text-left py-2.5 px-4 whitespace-nowrap w-auto font-light hover:bg-blue-50 transition-colors duration-100">
                            <a href="{{ route('courses.index', [
                                'sort_by' => 'course_description',
                                'sort_order' => $sortOrder === 'asc' ? 'desc' : 'asc',
                                'search_name' => $searchName,
                                'search_code' => $searchCode,
                                'department_id' => $departmentId
                            ]) }}" class="flex items-center w-full h-full">
                                Course Description
                            </a>
                        </th>
                        
                        <!-- Department -->
                        <th class="border border-[#DDD] text-left py-2.5 px-4 whitespace-nowrap w-1/12 font-light hover:bg-blue-50 transition-colors duration-100">
                            <a href="{{ route('courses.index', [
                                'sort_by' => 'department_code',
                                'sort_order' => $sortOrder === 'asc' ? 'desc' : 'asc',
                                'search_name' => $searchName,
                                'search_code' => $searchCode,
                                'department_id' => $departmentId
                            ]) }}" class="flex items-center w-full h-full">
                                Department
                            </a>
                        </th>
                        
                        <!-- Date Created -->
                        <th class="border border-[#DDD] text-left py-2.5 px-4 whitespace-nowrap w-1/12 font-light hover:bg-blue-50 transition-colors duration-100">
                            <a href="{{ route('courses.index', [
                                'sort_by' => 'created_at',
                                'sort_order' => $sortOrder === 'asc' ? 'desc' : 'asc',
                                'search_name' => $searchName,
                                'search_code' => $searchCode,
                                'department_id' => $departmentId
                            ]) }}" class="flex items-center w-full h-full">
                                Date Created
                            </a>
                        </th>
                        
                        <!-- Date Modified -->
                        <th class="border border-[#DDD] text-left py-2.5 px-4 whitespace-nowrap w-1/12 font-light hover:bg-blue-50 transition-colors duration-100">
                            <a href="{{ route('courses.index', [
                                'sort_by' => 'updated_at',
                                'sort_order' => $sortOrder === 'asc' ? 'desc' : 'asc',
                                'search_name' => $searchName,
                                'search_code' => $searchCode,
                                'department_id' => $departmentId
                            ]) }}" class="flex items-center w-full h-full">
                                Date Modified
                            </a>
                        </th>
                        
                        <!-- Actions -->
                        <th class="border border-[#DDD] text-left py-2.5 px-4 whitespace-nowrap w-28 font-light">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($courses as $course)
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
                    @empty
                        <tr>
                            <td colspan="7" class="py-2.5 px-4 text-center">No courses found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6">
            {{ $courses->appends([
                'search_name' => $searchName,
                'search_code' => $searchCode,
                'department_id' => $departmentId,
                'sort_by' => $sortBy,
                'sort_order' => $sortOrder
            ])->links() }}
        </div>
    </div>
    

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
@endsection

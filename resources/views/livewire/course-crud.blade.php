<div class="bg-white">
    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <!-- Page Title -->
    {{-- <div class="text-xl flex items-center p-5 pb-0">
        <img src="{{ asset('assets/icons/course.svg') }}" alt="Course">
        <div>
            Course Management
        </div>
    </div> --}}

    <div class="p-5 pb-0 flex flex-wrap justify-between items-center">

        <!-- Filters and Search Bar Section -->
        <div class="flex flex-wrap gap-4 items-center justify-start w-full sm:w-auto">
    
            <!-- Search Bar -->
            <div class="relative group w-full sm:w-[250px]">
                <input 
                    class="px-5 py-2 pr-20 border border-[#DDD] rounded appearance-none w-full transition-all duration-200 group-hover:border-[#923534]" 
                    wire:model.live="search" 
                    placeholder="Search..." 
                />
                <div class="absolute right-5 top-1/2 transform -translate-y-1/2 hover:text-blue-500 transition-colors duration-200">
                    <img class="w-4 h-4 group-hover:transform group-hover:-translate-x-1 transition-transform duration-200" src="{{ asset('assets/icons/search.svg') }}" alt="Search">
                </div>
            </div>
    
            <div class="relative group w-full sm:w-[250px]">
                <!-- Search Input -->
                <input 
                    wire:model.live="searchDepartment"
                    type="text"
                    class="px-5 py-2 pr-20 border border-[#DDD] rounded appearance-none w-full bg-[#F8F8F8] transition-all duration-200 group-hover:border-[#923534]"
                    placeholder="{{ $searchDepartment ? 'Searching: ' . $searchDepartment : 'Search Department...' }}"
                    wire:focus="showDropdown(true)" 
                    wire:blur="showDropdown(false)"  
                />
                
                <!-- Dropdown of Filtered Departments -->
                <div class="absolute left-0 right-0 mt-1 bg-white border border-[#DDD] rounded max-h-60 overflow-y-auto z-10"
                     style="display: {{ strlen($searchDepartment) > 0 || $isFocused ? 'block' : 'none' }};">
                    @if(strlen($searchDepartment) > 0) 
                        <!-- Show filtered departments if search input exists -->
                        @foreach($departments as $department)
                            @if(stripos($department->department_code, $searchDepartment) !== false)
                                <a href="javascript:void(0);" wire:click="selectDepartment({{ $department->department_id }})" 
                                class="block px-5 py-2 hover:bg-[#f1f1f1] cursor-pointer">
                                    {{ $department->department_code }}
                                </a>
                            @endif
                        @endforeach
                    @else
                        <!-- Show all departments if no search input -->
                        @foreach($departments as $department)
                            <a href="javascript:void(0);" wire:click="selectDepartment({{ $department->department_id }})" 
                            class="block px-5 py-2 hover:bg-[#f1f1f1] cursor-pointer">
                                {{ $department->department_code }}
                            </a>
                        @endforeach
                    @endif
                </div>
            
                <!-- Department Dropdown Arrow -->
                <div class="absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer hover:text-blue-500 transition-colors duration-200">
                    <img class="w-6 h-6 group-hover:transform" src="{{ asset('assets/icons/arrow1.svg') }}" alt="Arrow">
                </div>
            </div>
    
            <!-- Clear Button -->
            <div class="flex flex-cols w-full sm:w-auto">
                <button wire:click="clearFilters" class="w-full sm:w-auto px-4 py-2 rounded hover:bg-[#F8F8F8] transition duration-100">
                    <i class="fa fa-eraser"></i> Clear
                </button>
            </div>
    
        </div>
    
        <!-- Add Course Button -->
        <div class="w-full sm:w-auto mt-4 sm:mt-0">
            <button wire:click="showAddCourseModal" class="w-full sm:w-auto bg-[#923534] text-white py-2 px-4 rounded flex items-center gap-1 transition duration-100 hover:transform hover:scale-105">
                <img src="{{ asset('assets/icons/add.svg') }}" alt="Add">Course
            </button>
        </div>
    
    </div>
    
    
    <!-- Course List -->
    <div class="overflow-x-auto w-full p-5 pb-0">
        <table class="table table-bordered font-TT w-full table-auto">
            <thead>
                <tr class="uppercase font-normal bg-[#F8F8F8] text-black">
                    <th wire:click="sortBy('course_code')" class="items-center border border-[#DDD] text-left py-2 px-4 whitespace-nowrap font-light cursor-pointer hover:bg-blue-50 transition-colors duration-100">
                        <div class="flex items-center gap-2 justify-between" style="user-select: none;">
                            Course Code
                            <span class="ml-1 text-xs text-[#666]">
                                @if($sortField === 'course_code')
                                    <i class="fas {{ $sortDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                    <th wire:click="sortBy('course_name')" class="items-center border border-[#DDD] text-left py-2 px-4 whitespace-nowrap font-light cursor-pointer hover:bg-blue-50 transition-colors duration-100">
                        <div class="flex items-center gap-2 justify-between" style="user-select: none;">
                            Course Name
                            <span class="ml-1 text-xs text-[#666]">
                                @if($sortField === 'course_name')
                                    <i class="fas {{ $sortDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                    <th wire:click="sortBy('course_description')" class="items-center border border-[#DDD] text-left py-2 px-4 whitespace-nowrap font-light cursor-pointer hover:bg-blue-50 transition-colors duration-100">
                        <div class="flex items-center gap-2 justify-between" style="user-select: none;">
                            Course Description
                            <span class="ml-1 text-xs text-[#666]">
                                @if($sortField === 'course_description')
                                    <i class="fas {{ $sortDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                    <th wire:click="sortBy('department_id')" class="items-center border border-[#DDD] text-left py-2 px-4 whitespace-nowrap font-light cursor-pointer hover:bg-blue-50 transition-colors duration-100">
                        <div class="flex items-center gap-2 justify-between" style="user-select: none;">
                            Department
                            <span class="ml-1 text-xs text-[#666]">
                                @if($sortField === 'department_id')
                                    <i class="fas {{ $sortDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                    <th wire:click="sortBy('created_at')" class="items-center border border-[#DDD] text-left py-2 px-4 whitespace-nowrap font-light cursor-pointer hover:bg-blue-50 transition-colors duration-100">
                        <div class="flex items-center gap-2 justify-between" style="user-select: none;">
                            Created At
                            <span class="ml-1 text-xs text-[#666]">
                                @if($sortField === 'created_at')
                                    <i class="fas {{ $sortDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                    <th wire:click="sortBy('updated_at')" class="items-center border border-[#DDD] text-left py-2 px-4 whitespace-nowrap font-light cursor-pointer hover:bg-blue-50 transition-colors duration-100">
                        <div class="flex items-center gap-2 justify-between" style="user-select: none;">
                            Updated At
                            <span class="ml-1 text-xs text-[#666]">
                                @if($sortField === 'updated_at')
                                    <i class="fas {{ $sortDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                    <th class="border border-[#DDD] text-left py-2 px-4 whitespace-nowrap font-light hover:bg-blue-50 transition-colors duration-100">Actions</th>
                </tr>
            </thead>
            
            <tbody>
                @if($courses->isEmpty())
                <tr>
                    <td colspan="7" class="text-center py-4">No courses found.</td>
                </tr>
                @else
                @foreach ($courses as $course)
                <tr class="font-normal border border-[#DDD] text-[#666]-100 hover:bg-[#F8F8F8] transition-colors duration-100">
                    <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $course->course_code }}</td>
                    <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $course->course_name }}</td>
                    <td class="py-2 whitespace-nowrap px-4 truncate max-w-sm">{{ $course->course_description }}</td>
                    <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $course->department->department_code }}</td>
                    <td class="py-2 whitespace-nowrap px-4">{{ $course->created_at->format('Y-m-d H:i') }}</td>
                    <td class="py-2 whitespace-nowrap px-4">{{ $course->updated_at->format('Y-m-d H:i') }}</td>
                    <td class="py-2 whitespace-nowrap px-4">
                        <div class="flex items-center space-x-2">
                            <button wire:click="edit({{ $course->course_id }})">
                                <img src="{{ asset('assets/icons/edit.svg') }}" alt="Edit" class="hover:transform hover:rotate-12 bg-[#DDD] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                            </button>
                            <button wire:click="delete({{ $course->course_id }})">
                                <img src="{{ asset('assets/icons/delete.svg') }}" alt="Delete" class="hover:transform hover:rotate-12 bg-[#666] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                            </button>
                        </div>
                    </td>
                </tr>            
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="p-5">
        {{ $courses->links() }}
    </div>


    @if ($showDeleteConfirmation)
    <div class="absolute inset-0 bg-black bg-opacity-20 overflow-y-auto">
        <div class="bg-[#F8F8F8] rounded-lg w-full max-w-md mx-auto mt-20 relative">

            {{-- Header --}}
            <div class="p-4 flex justify-center font-semibold items-center bg-white font-TT rounded-t-lg relative">
                <button wire:click="cancelDelete" class="font-thin text-lg absolute left-4">
                    <i class="fa fa-times"></i>
                </button>
                <h3 class="text-lg">Delete Confirmation</h3>
            </div>

            {{-- Body --}}
            <div class="px-6 py-4 text-center">
                <p class="text-gray-700">Are you sure you want to delete this course?</p>
                <p class="text-sm text-gray-500 mt-2">This action cannot be undone.</p>
            </div>

            {{-- Footer --}}
            <div class="p-4 flex flex-wrap justify-center gap-4 bg-white rounded-b-lg">
                <button wire:click="confirmDelete" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 focus:outline-none focus:ring focus:ring-red-300">
                    Yes, Delete
                </button>
                <button wire:click="cancelDelete" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-300">
                    Cancel
                </button>
            </div>
        </div>
    </div>
    @endif



    {{-- Modal Add/Edit --}}
    @if ($showConfirmation)
    <div class="absolute inset-0 bg-black bg-opacity-20 overflow-y-auto">
        <div class="bg-[#F8F8F8] rounded-lg w-full max-w-lg mx-auto mt-20 relative">

            {{-- Header --}}
            <div class="p-4 flex justify-center font-semibold items-center bg-white font-TT rounded-t-lg relative">
                <button wire:click="$set('showConfirmation', false)" class="font-thin text-lg absolute left-4">
                    <i class="fa fa-times"></i>
                </button>
                @if ($updateMode)
                    <h3 class="text-lg">Edit Course</h3>
                @else
                    <h3 class="text-lg">Add Course</h3>
                @endif
            </div>

            {{-- Body --}}
            <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}">
                <div class="space-y-4 py-4 max-h-[70vh] px-6">
                    <div>
                        <label for="course_name" class="block text-sm font-medium text-gray-700">Course Name</label>
                        <input type="text" wire:model="course_name" id="course_name" class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300"/>
                        @error('course_name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="course_code" class="block text-sm font-medium text-gray-700">Course Code</label>
                        <input type="text" wire:model="course_code" id="course_code" class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300"/>
                        @error('course_code') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="course_description" class="block text-sm font-medium text-gray-700">Course Description</label>
                        <textarea rows="4" wire:model="course_description" id="course_description" class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300"></textarea>
                        @error('course_description') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
                        <select wire:model="department_id" id="department_id" class="bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300">
                            <option value="">Select Department</option>
                            @foreach ($this->getDepartments() as $department)
                                <option value="{{ $department->department_id }}">{{ $department->department_code }}</option>
                            @endforeach
                        </select>
                        @error('department_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Footer --}}
                <div class="p-4 flex flex-wrap justify-end gap-2 items-center bg-white rounded-b-lg">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300">{{ $updateMode ? 'Update' : 'Save' }}</button>
                    <button type="button" wire:click="$set('showConfirmation', false)" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-300">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    @endif




</div>

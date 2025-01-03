<div>
    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <textarea wire:model.live="text"></textarea>
    test: {{ $text }}


    <!-- Filters and Search Bar -->
    <div class="flex items-center space-x-4">
        <input type="text" wire:model="search" placeholder="Search by name or code" class="border px-4 py-2 rounded-md" />
        <button wire:click="searchCourses" class="bg-blue-500 text-white px-4 py-2 rounded-md">
            Search
        </button>

        <!-- Department Filter -->
        <select wire:model="departmentFilter" class="border px-4 py-2 rounded-md">
            <option value="">Filter by Department</option>
            @foreach ($this->getDepartments() as $department)
                <option value="{{ $department->department_id }}">{{ $department->name }}</option>
            @endforeach
        </select>

        <button wire:click="resetFilters" class="bg-gray-300 text-black px-4 py-2 rounded-md">
            Clear Filters
        </button>
    </div>

    <!-- Course List -->
    <table class="min-w-full table-auto mt-4">
        <thead>
            <tr>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Course Description</th>
                <th>Department</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $course)
                <tr>
                    <td>{{ $course->course_code }}</td>
                    <td>{{ $course->course_name }}</td>
                    <td>{{ $course->course_description }}</td>
                    <td>{{ $course->department->name }}</td>
                    <td>{{ $course->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $course->updated_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <button wire:click="edit({{ $course->course_id }})" class="bg-yellow-500 text-white px-4 py-2 rounded-md">Edit</button>
                        <button wire:click="delete({{ $course->course_id }})" class="bg-red-500 text-white px-4 py-2 rounded-md">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $courses->links() }}
    </div>

    <!-- Add/Edit Modal -->
    <div>
        <!-- Modal for adding or editing a course -->
        @if ($updateMode)
            <h3>Edit Course</h3>
        @else
            <h3>Add New Course</h3>
        @endif

        <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}">
            <div>
                <label for="course_name">Course Name</label>
                <input type="text" wire:model="course_name" id="course_name" class="border px-4 py-2 rounded-md" />
                @error('course_name') <span>{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="course_code">Course Code</label>
                <input type="text" wire:model="course_code" id="course_code" class="border px-4 py-2 rounded-md" />
                @error('course_code') <span>{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="course_description">Course Description</label>
                <textarea wire:model="course_description" id="course_description" class="border px-4 py-2 rounded-md"></textarea>
            </div>

            <div>
                <label for="department_id">Department</label>
                <select wire:model="department_id" class="border px-4 py-2 rounded-md">
                    <option value="">Select Department</option>
                    @foreach ($this->getDepartments() as $department)
                        <option value="{{ $department->department_id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                @error('department_id') <span>{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">{{ $updateMode ? 'Update' : 'Save' }}</button>
        </form>
    </div>
</div>

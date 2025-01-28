<div class="bg-white">

    <x-system-notification />

    <div class="p-5 pb-0 gap-2 flex flex-wrap items-center md:justify-start justify-center relative">
        
        <img src="{{ asset('storage/' . $faculty->profile_image) }}" alt="Profile Image" class="
        ring-1 ring-[#DDD] border-8 border-[#F8F8F8]
        object-cover rounded-full w-40 h-40">

        <div class="flex items-center flex-col md:flex-row w-full md:w-auto">
            <div class="ml-0 md:ml-5 flex-col flex gap-5 w-full">
                <!-- Name and Action Buttons -->
                <div class="py-2 flex justify-between w-full items-center border-b border-[#DDD] gap-5 md:mt-0 mt-5">
                    <span class="font-silka font-semibold text-[#2A2723] text-xl md:text-3xl">{{ $faculty->faculty_name }}</span>
                    <div class="flex items-center justify-end space-x-2">
                        <button wire:click="edit({{ $faculty->faculty_id }})"  class="w-8 h-8">
                            <img src="{{ asset('assets/icons/edit.svg') }}" alt="Edit" class="hover:transform hover:rotate-12 bg-[#DDD] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                        </button>
                    </div>
                </div>

                <!-- Profile Details -->
                <div class="text-gray-600">
                    <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/message.svg') }}" alt="Email">: <span>{{ $faculty->user->email }}</span></span>
                    <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/call.svg') }}" alt="Number">: <span>{{ $faculty->phone_number }}</span></span>
                    <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/department.svg') }}" alt="Department">: <span>{{ $faculty->department->department_name }}</span></span>
                </div>
            </div>
        </div>

        {{-- Add Button --}}
        <div class="w-full md:w-auto md:absolute bottom-0 right-0 md:mr-5">
            <x-add-button add="Assign Course" />
        </div>

    </div>  
    
    <div class="py-5">
        <x-table :action="true">
            <x-slot name="header">
    
                <x-table-header
                :allowSort="false"
                label="Section"/>
    
                <x-table-header
                :allowSort="false"
                label="Course Name"/>
    
                <x-table-header
                :allowSort="false"
                label="Course Code"/>
    
                <x-table-header
                :allowSort="false"
                label="Assigned At"/>
    
            </x-slot>
    
            <x-slot name="body">
                @if($faculty && $faculty->facultyCourse->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center py-2 px-4">
                            No courses assigned.
                        </td>
                    </tr>
                @else
                    @foreach($faculty->facultyCourse as $facultyCourse)
                        @php
                            $course = $facultyCourse->courseSection->course;
                            $section = $facultyCourse->courseSection->section;
                        @endphp
                        <tr class="font-normal border border-[#DDD] text-[#666]-100 hover:bg-[#F8F8F8] transition-colors duration-100">
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $section->section_code }}</td>
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $course->course_code }}</td>
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $course->course_name }}</td>
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $facultyCourse->courseSection->created_at }}</td>
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">
                                <div class="flex items-center justify-end space-x-2">
                                    <button wire:click="delete({{ $facultyCourse->faculty_course_id }})" class="w-8 h-8">
                                        <img src="{{ asset('assets/icons/delete.svg') }}" alt="Delete" class="hover:transform hover:rotate-12 bg-[#666] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
            
                @endif
            </x-slot>
        </x-table>
    </div>

{{-- Modal Delete --}}
<x-delete-modal label="faculty"/>

{{-- Modal Edit --}}
<x-edit-modal label="faculty">

    <!-- First Name -->
    <div class="flex w-full gap-5">
        <x-add-modal-data name="first_name" label="First Name:">
            <input 
                class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200" 
                type="text" 
                id="first_name" 
                wire:model="first_name">
        </x-add-modal-data>

        <!-- Last Name -->
        <x-add-modal-data name="last_name" label="Last Name:">
            <input 
                class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200" 
                type="text" 
                id="last_name" 
                wire:model="last_name">
        </x-add-modal-data>
    </div>
    
    <!-- Program -->
    <x-add-modal-data name="department_id" label="Department:">

        <x-select-department/>

    </x-add-modal-data>

    <!-- Profile Image -->
    <x-add-modal-data name="profile_image" label="Profile Image:">
        <input 
            class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200" 
            type="file" 
            id="profile_image" 
            accept="image/jpeg, image/png, image/jpg, image/gif, image/webp"
            wire:model="profile_image">
    </x-add-modal-data>

    <!-- Email -->
    {{-- <x-add-modal-data name="email" label="Email:">
        <input 
            class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200" 
            type="text" 
            id="email" 
            wire:model="email">
    </x-add-modal-data> --}}

    <!-- Phone Number -->
    <x-add-modal-data name="phone_number" label="Phone Number:">
        <input 
            class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200" 
            type="text" 
            id="phone_number" 
            wire:model="phone_number">
    </x-add-modal-data>

</x-edit-modal>

{{-- Modal Add --}}
<x-add-modal label="Course Section">

    <x-add-modal-data name="course_id" label="{{ $faculty->department->department_name }} Courses:">

        <x-select-section-course />

    </x-add-modal-data>

</x-add-modal>
</div>

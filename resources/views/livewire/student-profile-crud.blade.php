<div class="bg-white">

    <x-system-notification />

    <div class="p-5 pb-0 gap-5 flex flex-wrap items-center md:justify-start justify-center relative">
        
        <img src="{{ asset('storage/' . $student->profile_image) }}" alt="Profile Image" class="
        ring-1 ring-[#DDD] ring-offset-8 ring-offset-[#F8F8F8]
         object-cover rounded-full w-40 h-40 md:w-48 md:h-48">

        <div class="flex items-center flex-col md:flex-row w-full md:w-auto">
            <!-- Profile Image -->
            

            <div class="ml-0 md:ml-5 flex-col flex gap-5 w-full">
                <!-- Name and Action Buttons -->
                <div class="py-2 flex justify-between w-full items-center border-b border-[#DDD] gap-5 md:mt-0 mt-5">
                    <span class="font-silka font-semibold text-[#2A2723] text-xl md:text-3xl">{{ $student->student_name }}</span>
                    <div class="flex items-center justify-end space-x-2">
                        <button wire:click="edit({{ $student->student_id }})"  class="w-8 h-8">
                            <img src="{{ asset('assets/icons/edit.svg') }}" alt="Edit" class="hover:transform hover:rotate-12 bg-[#DDD] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                        </button>
                    </div>
                </div>
    
                <!-- Profile Details -->
                <div class="text-gray-600">
                    <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/message.svg') }}" alt="Email">: <span>{{ $student->user->email }}</span></span>
                    <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/call.svg') }}" alt="Number">: <span>{{ $student->phone_number }}</span></span>
                    <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/course.svg') }}" alt="Course">: <span>{{ $student->program->program_name }}</span></span>
                </div>
    
                <!-- Add Button -->
                <x-add-button add="Enroll Course" />
            </div>
        </div>
    </div>    

    <div class="pb-5">
        <x-table :action="true">
            <x-slot name="header">

                <x-table-header
                :allowSort="false"
                label="Section"
                />

                <x-table-header
                :allowSort="false"
                label="Course Code"/>

                <x-table-header
                :allowSort="false"
                label="Course Name"/>

                <x-table-header
                :allowSort="false"
                label="Faculty"/>

                <x-table-header
                :allowSort="false"
                label="Created At"/>

            </x-slot>

            <x-slot name="body">
                @if($student && $student->studentCourse->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center py-2 px-4">
                            No courses assigned.
                        </td>
                    </tr>
                @else
                    @foreach($student->studentCourse as $studentCourse)
                        <tr class="font-normal border border-[#DDD] text-[#666]-100 hover:bg-[#F8F8F8] transition-colors duration-100">
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $studentCourse->courseSection->section->section_code }}</td>
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $studentCourse->courseSection->course->course_code }}</td>
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $studentCourse->courseSection->course->course_name }}</td>
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">
                                {{ $studentCourse->courseSection->facultyCourse->first()->faculty->faculty_name ?? 'No Faculty Assigned' }}
                            </td>
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $studentCourse->courseSection->created_at }}</td>
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">
                                <div class="flex items-center justify-end space-x-2">
                                    <button wire:click="delete({{ $studentCourse->student_course_id }})"  class="w-8 h-8">
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
<x-delete-modal label="student"/>

<x-edit-modal label="student">

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
    <x-add-modal-data name="program_id" label="Program:">

        <x-select-program/>

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

    <x-select-section-courses />

</x-add-modal>

</div>

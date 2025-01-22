<div class="bg-white">

    <x-system-notification />
    
    {{-- <div class="p-5 pb-0 ">
        <span class="space-x-2 cursor-pointer group">
            <i class="fa-solid fa-arrow-left-long"></i><span class="text-[#2A2723] group-hover:ml-4 transition-all ease-out">Back</span>
        </span>
    </div> --}}

    <div class="p-5 pb-0 flex flex-wrap justify-between relative">
        <div class="flex items-center flex-col sm:flex-row w-full sm:w-auto">
            <!-- Profile Image -->
            <img src="{{ asset('assets/profiles/default.jpg') }}" alt="Profile Image" class="rounded-full w-40 h-40 sm:w-52 sm:h-52">
            
            <div class="ml-0 sm:ml-5 flex-col flex gap-5 w-full">
                <!-- Name and Action Buttons -->
                <div class="py-2 flex justify-between w-full items-center border-b border-[#DDD] gap-5 sm:mt-0 mt-5">
                    <span class="font-silka font-semibold text-[#2A2723] text-xl sm:text-3xl">{{ $student->first_name }} {{ $student->last_name }}</span>
                    <div class="flex items-center justify-end space-x-2">
                        <button wire:click="edit()">
                            <img src="{{ asset('assets/icons/edit.svg') }}" alt="Edit" class="hover:transform hover:rotate-12 bg-[#DDD] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                        </button>
                        <button wire:click="delete()">
                            <img src="{{ asset('assets/icons/delete.svg') }}" alt="Delete" class="hover:transform hover:rotate-12 bg-[#666] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
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
            @foreach($student->courseSections as $courseSection)
            <tr class="font-normal border border-[#DDD] text-[#666]-100 hover:bg-[#F8F8F8] transition-colors duration-100">
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $courseSection->section->section_code }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $courseSection->course->course_code }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $courseSection->course->course_name }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">
                    {{ $courseSection->faculty ? $courseSection->faculty->faculty_name : 'No Faculty Assigned' }}
                </td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $courseSection->created_at }}</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">
                    <div class="flex items-center justify-end space-x-2">
                        <button wire:click="delete()">
                            <img src="{{ asset('assets/icons/delete.svg') }}" alt="Delete" class="hover:transform hover:rotate-12 bg-[#666] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-table>
</div>
</div>

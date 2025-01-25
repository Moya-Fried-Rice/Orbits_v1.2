<div class="bg-white">

    <x-system-notification />

    <div class="p-5 pb-0 gap-5 flex flex-wrap items-center md:justify-start justify-center relative">
        
        <img src="{{ asset('storage/' . $faculty->profile_image) }}" alt="Profile Image" class="
        ring-1 ring-[#DDD] ring-offset-8 ring-offset-[#F8F8F8]
        object-cover rounded-full w-40 h-40 md:w-48 md:h-48">

        <div class="flex items-center flex-col md:flex-row w-full md:w-auto">
            <!-- Profile Image -->
            

            <div class="ml-0 md:ml-5 flex-col flex gap-5 w-full">
                <!-- Name and Action Buttons -->
                <div class="py-2 flex justify-between w-full items-center border-b border-[#DDD] gap-5 md:mt-0 mt-5">
                    <span class="font-silka font-semibold text-[#2A2723] text-xl md:text-3xl">{{ $faculty->first_name }} {{ $faculty->last_name }}</span>
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
    </div>  
    
    <div class="pb-5">
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
                @if($faculty && $faculty->courseSection->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center py-2 px-4">
                            No courses assigned.
                        </td>
                    </tr>
                @else
                    @foreach($faculty->courseSection as $courseSection)
                        <tr class="font-normal border border-[#DDD] text-[#666]-100 hover:bg-[#F8F8F8] transition-colors duration-100">
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $courseSection->section->section_code }}</td>
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $courseSection->course->course_code }}</td>
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $courseSection->course->course_name }}</td>
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $courseSection->created_at }}</td>
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">
                                <div class="flex items-center justify-end space-x-2">
                                    <button wire:click="delete({{ $courseSection->faculty_course_id }})"  class="w-8 h-8">
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

</div>

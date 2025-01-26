<div class="bg-white">

    <x-system-notification />

    <div class="p-5 pb-0 gap-5 flex flex-wrap items-center md:justify-between justify-center relative">
        
        <div class="flex items-center flex-col md:flex-row w-full md:w-auto">

            <div class="ml-0 md:ml-5 flex-col flex w-full">
                <!-- Name and Action Buttons -->
                <div class="py-2 flex justify-start w-full items-center border-b border-[#DDD] gap-5 md:mt-0 mt-5">
                    <span class="font-silka font-semibold text-[#2A2723] text-3xl">{{ $section->section_code }}</span>
                    <div class="flex items-center justify-end space-x-2">
                    </div>
                    <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/program.svg') }}" alt="Course">: <span>{{ $section->program->program_name }}</span></span>
                </div>
    
                <!-- Add Button -->
                
            </div>

            
        </div>
        <x-add-button add="Add Course" />
    </div>   

    <div class="pb-5">
        <x-table :action="true">
            <x-slot name="header">

                <x-table-header
                :allowSort="false"
                label="Course Code"
                />

                <x-table-header
                :allowSort="false"
                label="Course Name"/>

                <x-table-header
                :allowSort="false"
                label="No. of Student"/>

                <x-table-header
                :allowSort="false"
                label="Faculty"/>

                <x-table-header
                :allowSort="false"
                label="Created At"/>

            </x-slot>

            <x-slot name="body">
                @if($section && $section->courseSection->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center py-2 px-4">
                            No courses found.
                        </td>
                    </tr>
                @else
                    @foreach($section->courseSection as $courseSection)
                        @php
                            $course = $courseSection->course;
                            $faculty = $courseSection->facultyCourse->first()->faculty ?? null;
                        @endphp
                        <tr class="font-normal border border-[#DDD] text-[#666]-100 hover:bg-[#F8F8F8] transition-colors duration-100">
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $course->course_code }}</td>
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $course->course_name }}</td>
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $courseSection->studentCourse->count() }}</td>
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">
                                {{ $faculty ? $faculty->faculty_name : 'No Faculty Assigned' }}
                            </td>
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $courseSection->created_at }}</td>
                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">
                                <div class="flex items-center justify-end space-x-2">
                                    <button wire:click="delete({{ $courseSection->course_section_id }})" class="w-8 h-8">
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
<x-delete-modal label="Course"/>

{{-- Modal Add --}}
<x-add-modal label="Course">

    <x-select-course />

</x-add-modal>

</div>

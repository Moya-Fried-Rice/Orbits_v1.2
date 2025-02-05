<div class="bg-white">
    
    <x-system-notification />

    <div class="p-5 pb-0 flex flex-wrap items-center md:justify-between justify-center relative">
        
        <div class="flex items-center flex-col md:flex-row w-full md:w-auto xl:max-w-4xl">
            <div class="ml-0 md:ml-5 flex-col flex gap-5 w-full">
                <!-- Name and Action Buttons -->
                <div class="py-2 flex justify-between w-full items-center border-b border-[#DDD] gap-5">
                    <span class="font-silka font-semibold text-[#2A2723] text-xl md:text-3xl">{{ $program->program_code }} - {{ $program->program_name }}</span>
                    <div class="flex items-center justify-end space-x-2">
                        <button wire:click="edit({{ $program->program_id }})"  class="w-8 h-8">
                            <img src="{{ asset('assets/icons/edit.svg') }}" alt="Edit" class="hover:transform hover:rotate-12 bg-[#F8F8F8] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                        </button>
                    </div>
                </div>

                <!-- Profile Details -->
                <div class="text-gray-600">
                    <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/program.svg') }}" alt="Abbreviation">: <span>Abbreviation - {{ $program->abbreviation }}</span></span>
                    <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/department.svg') }}" alt="Department">: <span>{{ $program->department->department_name }}</span></span>
                    <span class="flex items-start gap-2 justify-start w-auto md:max-w-[70%] xl:max-w-full"><img class="w-5 mt-1" src="{{ asset('assets/icons/survey.svg') }}" alt="Description">: <span>{{ $program->program_description }}</span></span>
                </div>
            </div>
        </div>

        {{-- Add Button --}}
        <div class="w-full md:w-auto md:absolute bottom-0 right-0 md:mr-5">
            <x-add-button add="Assign Course" />
        </div>
        
    </div>  

<div class="py-5 pt-0">

    @if ($program && $program->programCourses->isEmpty())
        <div class="text-center text-[#666] pt-10">
            No courses found.
        </div>
    @else
    
        @foreach ($program->programCourses->pluck('year_level')->unique()->sort() as $year_level)

            <div class="pt-10 text-[#2A2723] text-center w-full">** {{ strtoupper($this->ordinalWord($year_level)) }} YEAR **</div>

            <div class="grid grid-cols-1 xl:grid-cols-2">

                @foreach ($program->programCourses->where('year_level', $year_level)->pluck('semester')->unique()->sort() as $semester)

                    <div class="p-5">
                        <div>{{ $this->ordinal($semester) }} Semester</div>
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
                                label="Lec"/>

                                <x-table-header
                                :allowSort="false"
                                label="Lab"/>

                                <x-table-header
                                :allowSort="false"
                                label="Units"/>

                            </x-slot>

                            <x-slot name="body">
                                @php
                                    $coursesInSemester = $program->programCourses->where('year_level', $year_level)->where('semester', $semester);
                                @endphp

                                @if ($program && $program->programCourses->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center py-2 px-4">
                                            No courses found.
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($coursesInSemester as $programCourse)
                                        @php
                                            $course = $programCourse->course;
                                        @endphp
                                        <tr class="font-normal border border-[#DDD] text-[#666]-100 hover:bg-[#F8F8F8] transition-colors duration-100">
                                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $course->course_code }}</td>
                                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-20">{{ $course->course_name }}</td>
                                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $course->lec }}</td>
                                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $course->lab }}</td>
                                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">{{ $course->units }}</td>
                                            <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <button wire:click="delete({{ $programCourse->program_course_id }})" class="w-8 h-8">
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
                @endforeach

            </div>
        
        @endforeach

    @endif
</div>

{{-- Modal Delete --}}
<x-delete-modal label="course"/>

<!-- Modal Edit -->
<x-edit-modal label="program">

    <!-- Program Name -->
    <x-add-modal-data name="program_name" label="Program Name:">
        <input 
            class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200" 
            type="text" 
            id="program_name" 
            wire:model="program_name">
    </x-add-modal-data>

    <div class="flex w-full gap-5">
        <!-- Program Code -->
        <x-add-modal-data name="program_code" label="Program Code:">
            <input 
                class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200" 
                type="text" 
                id="program_code" 
                wire:model="program_code">
        </x-add-modal-data>

        <!-- Abbreviation -->
        <x-add-modal-data name="abbreviation" label="Abbreviation:">
            <input 
                class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200" 
                type="text" 
                id="abbreviation" 
                wire:model="abbreviation">
        </x-add-modal-data>
    </div>

    <!-- Program Description -->
    <x-add-modal-data name="program_description" label="Program Description:">
        <textarea 
            class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200" 
            id="program_description" 
            wire:model="program_description"></textarea>
    </x-add-modal-data>

    <!-- Department -->
    <x-add-modal-data name="department_id" label="Department:">
        
        <x-select-department/>

    </x-add-modal-data>

</x-edit-modal>

{{-- Modal Add --}}
<x-add-modal label="Course">

    <div class="flex w-full gap-5">
        <!-- Program Code -->
        <x-add-modal-data name="year_level" label="Year Level:">
            <input 
                class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200" 
                type="number" 
                id="year_level" 
                min="1"
                max="15"
                wire:model="year_level">
        </x-add-modal-data>

        <!-- Semester -->
        <x-add-modal-data name="semester" label="Semester:">
            <input 
                class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200" 
                type="number" 
                id="semester" 
                min="1"
                max="15"
                wire:model="semester">
        </x-add-modal-data>
    </div>

    <x-select-course />

</x-add-modal>


</div>

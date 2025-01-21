@extends('layouts.master')

@section('title')

    <title>Orbits | Admin Dashboard</title>
    
@endsection

@section('content')

<div class="bg-white">

    <x-system-notification />
    
    <div class="p-5 pb-0 ">
        <span class="space-x-2 opacity-50 hover:opacity-100 transition-all ease-in cursor-pointer group">
            <i class="fa-solid fa-arrow-left-long"></i><span class="font-medium group-hover:ml-4 transition-all ease-out">Back</span>
        </span>
    </div>

    <div class="p-5 pb-0 flex flex-wrap justify-between relative">
        <div class="flex items-center flex-col sm:flex-row w-full sm:w-auto">
            <!-- Profile Image -->
            <img src="{{ asset('assets/profiles/default.jpg') }}" alt="Delete" class="rounded-full w-40 h-40 sm:w-52 sm:h-52">
            
            <div class="ml-0 sm:ml-5 flex-col flex gap-5 w-full">
                <!-- Name and Action Buttons -->
                <div class="py-2 flex justify-between w-full items-center border-b border-[#DDD] gap-5 sm:mt-0 mt-5">
                    <span class="font-silka font-semibold text-[#2A2723] text-xl sm:text-3xl">Benjamin Moore</span>
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
                    <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/message.svg') }}" alt="Email">: <span>abcjvhert@gmail.com</span></span>
                    <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/call.svg') }}" alt="Number">: <span>09156578280</span></span>
                    <span class="flex items-center gap-2 justify-start"><img class="w-5" src="{{ asset('assets/icons/course.svg') }}" alt="Course">: <span>BS Computer Science - BSCS</span></span>
                </div>

                <!-- Add Button -->
                <x-add-button add="Enroll Course" />
                
            </div>
        </div>
    </div>


    <x-table :action="true">
        <x-slot name="header">

            <x-table-header
            sortField=""
            sortDirection=""
            data=""
            label="Section"/>

            <x-table-header
            sortField=""
            sortDirection=""
            data=""
            label="Course Code"/>

            <x-table-header
            sortField=""
            sortDirection=""
            data=""
            label="Course Name"/>

            <x-table-header
            sortField=""
            sortDirection=""
            data=""
            label="Faculty"/>

            <x-table-header
            sortField=""
            sortDirection=""
            data=""
            label="CREATED AT"/>

        </x-slot>

        <x-slot name="body">
            <tr class="font-normal border border-[#DDD] text-[#666]-100 hover:bg-[#F8F8F8] transition-colors duration-100">
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">CS101</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">NSTPN02G</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">National Service Training Program 2</td>
                <td class="py-2 whitespace-nowrap px-4">James White</td>
                <td class="py-2 whitespace-nowrap px-4">2024-12-02 11:05</td>
                <td class="py-2 whitespace-nowrap px-4 truncate max-w-xs">
                    <div class="flex items-center justify-end space-x-2">
                        <button wire:click="delete()">
                            <img src="{{ asset('assets/icons/delete.svg') }}" alt="Delete" class="hover:transform hover:rotate-12 bg-[#666] p-1.5 w-8 h-8 rounded transition duration-100 border hover:border-[#923534]">
                        </button>
                    </div>
                </td>
            </tr>
        </x-slot>
    </x-table>







    {{-- <!-- Evaluation Section -->
    <div class="bg-white p-6">
        Evaluation
    </div>

    <!-- Cards Section -->
    <div class="grid grid-rows-1 gap-5 
    sm:grid-cols-2 
    md:grid-cols-2 
    lg:grid-cols-3 
    xl:grid-cols-6">

        <x-card 
            count="{{ \App\Models\Student::count() }}" 
            label="Students" 
            icon="{{ asset('assets/icons/student.svg') }}" 
        />

        <x-card 
            count="{{ \App\Models\Faculty::count() }}" 
            label="Faculty" 
            icon="{{ asset('assets/icons/faculty.svg') }}" 
        />

        <x-card 
            count="{{ \App\Models\Course::count() }}" 
            label="Courses" 
            icon="{{ asset('assets/icons/course.svg') }}" 
        />

        <x-card 
            count="{{ \App\Models\Program::count() }}" 
            label="Programs" 
            icon="{{ asset('assets/icons/program.svg') }}" 
        />

        <x-card 
            count="{{ \App\Models\CourseSection::count() }}" 
            label="Sections" 
            icon="{{ asset('assets/icons/section.svg') }}" 
        />

        <x-card 
            count="{{ \App\Models\Student::count() }}" 
            label="Users" 
            icon="{{ asset('assets/icons/account.svg') }}" 
        />

    </div>

    <!-- Progress Section -->
    <div class="grid gap-5 
    sm:grid-cols-2 
    md:grid-cols-2 
    lg:grid-cols-3 
    xl:grid-cols-4">

        <div class="bg-white p-6
        sm:col-span-2
        md:col-span-2
        lg:col-span-1
        xl:col-span-1">

        </div>

        <div class="bg-white p-6
        sm:col-span-2
        md:col-span-2
        lg:col-span-2
        xl:col-span-2">

        </div>

        <div class="bg-white p-6
        sm:col-span-2
        md:col-span-2
        lg:col-span-3 
        xl:col-span-1 ">
        
        </div>

    </div>

    <!-- Monitoring Section -->
    <div class="grid gap-5 
    sm:grid-cols-1 
    md:grid-cols-1 
    lg:grid-cols-2 
    xl:grid-cols-2">

        <div class="bg-white p-6
        sm:col-span-1
        md:col-span-1
        lg:col-span-2
        xl:col-span-1">

        </div>

        <div class="bg-white p-6
        sm:col-span-1
        md:col-span-1
        lg:col-span-2
        xl:col-span-1">

        </div>

    </div> --}}

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


@endsection

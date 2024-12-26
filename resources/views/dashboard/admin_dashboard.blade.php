@extends('layouts.master')

@section('content')

        <div>
            
            <div class="grid grid-rows-12 gap-5 text-shadow-white 
            sm:grid-cols-1 
            md:grid-cols-2 
            lg:grid-cols-3 
            xl:grid-cols-6 
            {{-- sm:bg-red-200 
            md:bg-blue-200
            lg:bg-green-200
            xl:bg-yellow-200 --}}
            ">

                <div class="bg-white rounded-lg p-6 
                sm:col-span-1
                md:col-span-2 
                lg:col-span-3
                xl:col-span-6">

                </div>

                <div class="bg-white rounded-lg p-6 flex flex-1 justify-between items-center relative overflow-hidden
                sm:col-span-1
                md:col-span-1
                lg:col-span-1
                xl:col-span-1">
                    <div class="relative z-10">
                        <h3 class="text-2xl font-semibold">53</h3>
                        <p>Students</p>
                    </div>
                    <div class="absolute -right-8 h-full flex items-center z-0">
                        <img src="{{ asset('assets/icons/student.svg') }}" class="border-8 bg-[#EFEFEF] opacity-30 rounded-full p-10 w-36 h-36" alt="Icon">
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 flex flex-1 justify-between items-center relative overflow-hidden
                sm:col-span-1
                md:col-span-1
                lg:col-span-1
                xl:col-span-1">
                    <div class="relative z-10">
                        <h3 class="text-2xl font-semibold">12</h3>
                        <p>Faculty</p>
                    </div>
                    <div class="absolute -right-8 h-full flex items-center z-0">
                        <img src="{{ asset('assets/icons/faculty.svg') }}" class="border-8 bg-[#EFEFEF] opacity-30 rounded-full p-10 w-36 h-36" alt="Icon">
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 flex flex-1 justify-between items-center relative overflow-hidden
                sm:col-span-1
                md:col-span-1
                lg:col-span-1
                xl:col-span-1">
                    <div class="relative z-10">
                        <h3 class="text-2xl font-semibold">25</h3>
                        <p>Courses</p>
                    </div>
                    <div class="absolute -right-8 h-full flex items-center z-0">
                        <img src="{{ asset('assets/icons/course.svg') }}" class="border-8 bg-[#EFEFEF] opacity-30 rounded-full p-10 w-36 h-36" alt="Icon">
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 flex flex-1 justify-between items-center relative overflow-hidden
                sm:col-span-1
                md:col-span-1
                lg:col-span-1
                xl:col-span-1">
                    <div class="relative z-10">
                        <h3 class="text-2xl font-semibold">8</h3>
                        <p>Programs</p>
                    </div>
                    <div class="absolute -right-8 h-full flex items-center z-0">
                        <img src="{{ asset('assets/icons/program.svg') }}" class="border-8 bg-[#EFEFEF] opacity-30 rounded-full p-10 w-36 h-36" alt="Icon">
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 flex flex-1 justify-between items-center relative overflow-hidden
                sm:col-span-1
                md:col-span-1
                lg:col-span-1
                xl:col-span-1">
                    <div class="relative z-10">
                        <h3 class="text-2xl font-semibold">15</h3>
                        <p>Sections</p>
                    </div>
                    <div class="absolute -right-8 h-full flex items-center z-0">
                        <img src="{{ asset('assets/icons/section.svg') }}" class="border-8 bg-[#EFEFEF] opacity-30 rounded-full p-10 w-36 h-36" alt="Icon">
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 flex flex-1 justify-between items-center relative overflow-hidden
                sm:col-span-1
                md:col-span-1
                lg:col-span-1
                xl:col-span-1">
                    <div class="relative z-10">
                        <h3 class="text-2xl font-semibold">5</h3>
                        <p>Users</p>
                    </div>
                    <div class="absolute -right-8 h-full flex items-center z-0">
                        <img src="{{ asset('assets/icons/account.svg') }}" class="border-8 bg-[#EFEFEF] opacity-30 rounded-full p-10 w-36 h-36" alt="Icon">
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6
                sm:col-span-1
                md:col-span-2
                lg:col-span-1
                xl:col-span-2">
                1
                </div>

                <div class="bg-white rounded-lg p-6
                sm:col-span-1
                md:col-span-2
                lg:col-span-1
                xl:col-span-3">
                2
                </div>

                <div class="bg-white rounded-lg p-6
                sm:col-span-1
                md:col-span-2
                lg:col-span-1 lg:row-span-2
                xl:col-span-1 xl:row-span-2">
                2 row
                </div>
                
                <div class="bg-white rounded-lg p-6
                sm:col-span-1
                md:col-span-2
                lg:col-span-2
                xl:col-span-5">
                3
                </div>
              
            </div>
            
        </div>
        
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
@endsection

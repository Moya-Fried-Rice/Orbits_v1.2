@extends('layouts.master')

@section('content')

        <div>
            
            <div class="grid grid-rows-12  gap-5
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

                <div class="bg-white rounded-lg p-6 flex flex-1 justify-between items-center
                sm:col-span-1
                md:col-span-1
                lg:col-span-1
                xl:col-span-1">
                    <div>
                        <h3 class="text-2xl font-semibold">53</h3>
                        <p>Users</p>
                    </div>
                    <div>
                        <img src="{{ asset('assets/icons/section.svg') }}" class="bg-[#EFEFEF] rounded-full p-3 w-12 h-12" alt="Icon">
                    </div>
                </div>
              
                <div class="bg-white rounded-lg p-6 flex flex-1 justify-between items-center
                sm:col-span-1
                md:col-span-1
                lg:col-span-1
                xl:col-span-1">
                    <div>
                        <h3 class="text-2xl font-semibold">12</h3>
                        <p>Faculty</p>
                    </div>
                    <div>
                        <img src="{{ asset('assets/icons/faculty.svg') }}" class="bg-[#EFEFEF] rounded-full p-3 w-12 h-12" alt="Icon">
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 flex flex-1 justify-between items-center
                sm:col-span-1
                md:col-span-1
                lg:col-span-1
                xl:col-span-1">
                    <div>
                        <h3 class="text-2xl font-semibold">25</h3>
                        <p>Courses</p>
                    </div>
                    <div>
                        <img src="{{ asset('assets/icons/course.svg') }}" class="bg-[#EFEFEF] rounded-full p-3 w-12 h-12" alt="Icon">
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 flex flex-1 justify-between items-center
                sm:col-span-1
                md:col-span-1
                lg:col-span-1
                xl:col-span-1">
                    <div>
                        <h3 class="text-2xl font-semibold">8</h3>
                        <p>Programs</p>
                    </div>
                    <div>
                        <img src="{{ asset('assets/icons/program.svg') }}" class="bg-[#EFEFEF] rounded-full p-3 w-12 h-12" alt="Icon">
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 flex flex-1 justify-between items-center
                sm:col-span-1
                md:col-span-1
                lg:col-span-1
                xl:col-span-1">
                    <div>
                        <h3 class="text-2xl font-semibold">15</h3>
                        <p>Sections</p>
                    </div>
                    <div>
                        <img src="{{ asset('assets/icons/section.svg') }}" class="bg-[#EFEFEF] rounded-full p-3 w-12 h-12" alt="Icon">
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 flex flex-1 justify-between items-center
                sm:col-span-1
                md:col-span-1
                lg:col-span-1
                xl:col-span-1">
                    <div>
                        <h3 class="text-2xl font-semibold">5</h3>
                        <p>Departments</p>
                    </div>
                    <div>
                        <img src="{{ asset('assets/icons/department.svg') }}" class="bg-[#EFEFEF] rounded-full p-3 w-12 h-12" alt="Icon">
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

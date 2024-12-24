{{-- <div x-data="{ showData: false, showReport: false }" class="flex flex-col w-64 h-screen bg-white text-[#666]">
    <div class="flex items-center justify-center py-4">
        <img src="{{ asset('assets/logo/logo.png') }}" alt="Logo" class="w-28 h-28">
    </div>
    <nav class="flex-1 py-4 overflow-y-auto overflow-x-hidden">
        <a href="#" class="block w-full px-4 py-4 text-base font-semibold text-[#666] hover:text-[#631111] hover:ml-1 flex items-center transition-all duration-200">
            <img src="{{ asset('assets/icons/monitor.svg') }}" alt="Dashboard Icon" class="w-6 h-6 mr-2">
            Dashboard
        </a>
        <button @click="showData = !showData" class="block w-full px-4 py-4 text-base font-semibold text-left text-[#666] hover:text-[#631111] hover:ml-1 flex items-center transition-all duration-200">
            <img src="{{ asset('assets/icons/data.svg') }}" alt="Data Management Icon" class="w-6 h-6 mr-2">
            Data Management
            <i class="ml-auto transition-transform duration-200 fas fa-caret-right " :class="{'transform rotate-90': showData, 'transform rotate-0': !showData}"></i>
        </button>
        <div x-show="showData" x-transition:enter="transition-all duration-500" 
             x-transition:enter-start="max-h-0 opacity-0" 
             x-transition:enter-end="max-h-screen opacity-100" 
             x-transition:leave="transition-all duration-500" 
             x-transition:leave-start="max-h-screen opacity-100" 
             x-transition:leave-end="max-h-0 opacity-0" 
             class="bg-[#F8F8F8] overflow-hidden">
            <!-- Nested Links -->
            <a href="#" class="block w-full px-4 py-4 text-base font-semibold text-[#666] hover:text-[#631111] hover:ml-1 flex items-center transition-all duration-200">
                <img src="{{ asset('assets/icons/faculty.svg') }}" alt="Faculty Icon" class="w-6 h-6 mr-2">
                Faculty
            </a>
            <a href="#" class="block w-full px-4 py-4 text-base font-semibold text-[#666] hover:text-[#631111] hover:ml-1 flex items-center transition-all duration-200">
                <img src="{{ asset('assets/icons/student.svg') }}" alt="Students Icon" class="w-6 h-6 mr-2">
                Students
            </a>
            <a href="#" class="block w-full px-4 py-4 text-base font-semibold text-[#666] hover:text-[#631111] hover:ml-1 flex items-center transition-all duration-200">
                <img src="{{ asset('assets/icons/course.svg') }}" alt="Courses Icon" class="w-6 h-6 mr-2">
                Courses
            </a>
            <a href="#" class="block w-full px-4 py-4 text-base font-semibold text-[#666] hover:text-[#631111] hover:ml-1 flex items-center transition-all duration-200">
                <img src="{{ asset('assets/icons/program.svg') }}" alt="Programs Icon" class="w-6 h-6 mr-2">
                Programs
            </a>
            <a href="#" class="block w-full px-4 py-4 text-base font-semibold text-[#666] hover:text-[#631111] hover:ml-1 flex items-center transition-all duration-200">
                <img src="{{ asset('assets/icons/department.svg') }}" alt="Departments Icon" class="w-6 h-6 mr-2">
                Departments
            </a>
            <a href="#" class="block w-full px-4 py-4 text-base font-semibold text-[#666] hover:text-[#631111] hover:ml-1 flex items-center transition-all duration-200">
                <img src="{{ asset('assets/icons/survey.svg') }}" alt="Survey Icon" class="w-6 h-6 mr-2">
                Survey
            </a>
            <a href="#" class="block w-full px-4 py-4 text-base font-semibold text-[#666] hover:text-[#631111] hover:ml-1 flex items-center transition-all duration-200">
                <img src="{{ asset('assets/icons/section.svg') }}" alt="Sections Icon" class="w-6 h-6 mr-2">
                Sections
            </a>
            <a href="#" class="block w-full px-4 py-4 text-base font-semibold text-[#666] hover:text-[#631111] hover:ml-1 flex items-center transition-all duration-200">
                <img src="{{ asset('assets/icons/account.svg') }}" alt="Accounts Icon" class="w-6 h-6 mr-2">
                Accounts
            </a>
        </div>
        <a href="#" class="block w-full px-4 py-4 text-base font-semibold text-[#666] hover:text-[#631111] hover:ml-1 flex items-center transition-all duration-200">
            <img src="{{ asset('assets/icons/evaluation.svg') }}" alt="Evaluations Icon" class="w-6 h-6 mr-2">
            Evaluations
        </a>
        <button @click="showReport = !showReport" class="block w-full px-4 py-4 text-base font-semibold text-left text-[#666] hover:text-[#631111] hover:ml-1 flex items-center transition-all duration-200">
            <img src="{{ asset('assets/icons/report.svg') }}" alt="Reports Icon" class="w-6 h-6 mr-2">
            Reports
            <i class="ml-auto transition-transform duration-200 fas fa-caret-right " :class="{'transform rotate-90': showReport, 'transform rotate-0': !showReport}"></i>
        </button>
        <div x-show="showReport" x-transition:enter="transition-all duration-500" 
             x-transition:enter-start="max-h-0 opacity-0" 
             x-transition:enter-end="max-h-screen opacity-100" 
             x-transition:leave="transition-all duration-500" 
             x-transition:leave-start="max-h-screen opacity-100" 
             x-transition:leave-end="max-h-0 opacity-0" 
             class="bg-[#F8F8F8] overflow-hidden">
            <!-- Nested Links -->
            <a href="#" class="block w-full px-4 py-4 text-base font-semibold text-[#666] hover:text-[#631111] hover:ml-1 flex items-center transition-all duration-200">
                <img src="{{ asset('assets/icons/result.svg') }}" alt="Results Icon" class="w-6 h-6 mr-2">
                Results
            </a>
            <a href="#" class="block w-full px-4 py-4 text-base font-semibold text-[#666] hover:text-[#631111] hover:ml-1 flex items-center transition-all duration-200">
                <img src="{{ asset('assets/icons/ranking.svg') }}" alt="Students Icon" class="w-6 h-6 mr-2">
                Faculty Ranking
            </a>
        </div>
        <a href="#" class="block w-full px-4 py-4  text-base font-semibold text-[#666] hover:text-[#631111] hover:ml-1 flex items-center transition-all duration-200">
            <img src="{{ asset('assets/icons/monitor.svg') }}" alt="Monitor Icon" class="w-6 h-6 mr-2">
            Monitor
        </a>
        <a href="#" class="block w-full px-4 py-4 text-base font-semibold text-[#666] hover:text-[#631111] hover:ml-1 flex items-center transition-all duration-200">
            <img src="{{ asset('assets/icons/logout.svg') }}" alt="Sign Out Icon" class="w-6 h-6 mr-2">
            Sign Out
        </a>
    </nav>
</div> --}}
<div class="flex flex-col border-r-2 border-[#D4D4D4]">
    <div class="flex flex-col w-auto h-screen bg-white text-[#666]">
        <div class="flex-1">
            <div class="items-center p-3 justify-content">
                <img src="{{ asset('assets/icons/home.svg') }}" alt="Dashboard Icon" class="w-6 h-6">   
            </div>
            <div class="items-center p-3 justify-content">
                <img src="{{ asset('assets/icons/data.svg') }}" alt="Dashboard Icon" class="w-6 h-6">   
            </div>
            <div class="items-center p-3 justify-content">
                <img src="{{ asset('assets/icons/evaluation.svg') }}" alt="Dashboard Icon" class="w-6 h-6">   
            </div>
            <div class="items-center p-3 justify-content">
                <img src="{{ asset('assets/icons/report.svg') }}" alt="Dashboard Icon" class="w-6 h-6">   
            </div>
            <div class="items-center p-3 justify-content">
                <img src="{{ asset('assets/icons/monitor.svg') }}" alt="Dashboard Icon" class="w-6 h-6">   
            </div>
            <div class="items-center p-3 justify-content">
                <img src="{{ asset('assets/icons/logout.svg') }}" alt="Dashboard Icon" class="w-6 h-6">   
            </div>
        </div>
    </div>
</div>
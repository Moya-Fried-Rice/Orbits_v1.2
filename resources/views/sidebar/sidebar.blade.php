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
        <div x-show="showData" 
             x-transition:enter="transition-all duration-500" 
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
        <div x-show="showReport" 
             x-transition:enter="transition-all duration-500" 
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

<div class="border-r border-[#D4D4D4] bg-white text-[#666] font-semibold overflow-y-auto">
    <!-- Dashboard -->
    <a href="#" class="flex items-center justify-content group m-2 hover:bg-[#E6E6E6] rounded transition-background duration-100">
        <img src="{{ asset('assets/icons/home.svg') }}" alt="Dashboard Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded transition-colors duration-300">
        <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.28,1.27), transform 0.1s ease, color 0.1s ease;" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
            Dashboard
        </span>
    </a>
                
    <!-- Data Management -->
    <a href="#" @click="showData = !showData" class="flex items-center justify-content group m-2 hover:bg-[#E6E6E6] rounded transition-background duration-100">
        <img src="{{ asset('assets/icons/data.svg') }}" alt="Data Management Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded hover:bg-[#E6E6E6] transition-colors duration-300">
        <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.28,1.27), transform 0.1s ease, color 0.1s ease;" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
            Data Management
        </span>
        <i x-show="showSidebar" class="fas fa-caret-right mr-2 transition-transform duration-200" :class="{'transform rotate-90': showData, 'transform rotate-0': !showData}"></i>
    </a>
    <div x-show="showData" class="bg-[#F8F8F8] overflow-hidden transition-all duration-500">
        <!-- Nested Links -->
        <a href="#" class="flex items-center justify-content group m-2 hover:bg-[#E6E6E6] rounded transition-background duration-100">
            <img src="{{ asset('assets/icons/faculty.svg') }}" alt="Faculty Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded hover:bg-[#E6E6E6] transition-colors duration-300">
            <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.28,1.27), transform 0.1s ease, color 0.1s ease;" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
                Faculty
            </span>
        </a>
        <a href="#" class="flex items-center justify-content group m-2 hover:bg-[#E6E6E6] rounded transition-background duration-100">
            <img src="{{ asset('assets/icons/student.svg') }}" alt="Students Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded hover:bg-[#E6E6E6] transition-colors duration-300">
            <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.28,1.27), transform 0.1s ease, color 0.1s ease;" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
                Students
            </span>
        </a>
        <a href="#" class="flex items-center justify-content group m-2 hover:bg-[#E6E6E6] rounded transition-background duration-100">
            <img src="{{ asset('assets/icons/course.svg') }}" alt="Courses Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded hover:bg-[#E6E6E6] transition-colors duration-300">
            <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.28,1.27), transform 0.1s ease, color 0.1s ease;" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
                Courses
            </span>
        </a>
        <a href="#" class="flex items-center justify-content group m-2 hover:bg-[#E6E6E6] rounded transition-background duration-100">
            <img src="{{ asset('assets/icons/program.svg') }}" alt="Programs Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded hover:bg-[#E6E6E6] transition-colors duration-300">
            <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.28,1.27), transform 0.1s ease, color 0.1s ease;" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
                Programs
            </span>
        </a>
        <a href="#" class="flex items-center justify-content group m-2 hover:bg-[#E6E6E6] rounded transition-background duration-100">
            <img src="{{ asset('assets/icons/department.svg') }}" alt="Departments Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded hover:bg-[#E6E6E6] transition-colors duration-300">
            <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.28,1.27), transform 0.1s ease, color 0.1s ease;" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
                Departments
            </span>
        </a>
        <a href="#" class="flex items-center justify-content group m-2 hover:bg-[#E6E6E6] rounded transition-background duration-100">
            <img src="{{ asset('assets/icons/survey.svg') }}" alt="Survey Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded hover:bg-[#E6E6E6] transition-colors duration-300">
            <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.28,1.27), transform 0.1s ease, color 0.1s ease;" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
                Survey
            </span>
        </a>
        <a href="#" class="flex items-center justify-content group m-2 hover:bg-[#E6E6E6] rounded transition-background duration-100">
            <img src="{{ asset('assets/icons/section.svg') }}" alt="Sections Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded hover:bg-[#E6E6E6] transition-colors duration-300">
            <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.28,1.27), transform 0.1s ease, color 0.1s ease;" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
                Sections
            </span>
        </a>
        <a href="#" class="flex items-center justify-content group m-2 hover:bg-[#E6E6E6] rounded transition-background duration-100">
            <img src="{{ asset('assets/icons/account.svg') }}" alt="Accounts Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded hover:bg-[#E6E6E6] transition-colors duration-300">
            <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.28,1.27), transform 0.1s ease, color 0.1s ease;" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
                Accounts
            </span>
        </a>
    </div>
    
    <!-- Evaluation -->
    <a href="#" class="flex items-center justify-content group m-2 hover:bg-[#E6E6E6] rounded transition-background duration-100">
        <img src="{{ asset('assets/icons/evaluation.svg') }}" alt="Evaluation Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded hover:bg-[#E6E6E6] transition-colors duration-300">
        <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.28,1.27), transform 0.1s ease, color 0.1s ease;" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
            Evaluation
        </span>
    </a>
    
    <!-- Reports -->
    <a href="#" @click="showReport = !showReport" class="flex items-center justify-content group m-2 hover:bg-[#E6E6E6] rounded transition-background duration-100">
        <img src="{{ asset('assets/icons/report.svg') }}" alt="Reports Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded hover:bg-[#E6E6E6] transition-colors duration-300">
        <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.28,1.27), transform 0.1s ease, color 0.1s ease;" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
            Reports
        </span>
        <i x-show="showSidebar" class="fas fa-caret-right mr-2 transition-transform duration-200" :class="{'transform rotate-90': showReport, 'transform rotate-0': !showReport}"></i>
    </a>
    <div x-show="showReport" class="bg-[#F8F8F8] overflow-hidden transition-all duration-500">
        <!-- Nested Links -->
        <a href="#" class="flex items-center justify-content group m-2 hover:bg-[#E6E6E6] rounded transition-background duration-100">
            <img src="{{ asset('assets/icons/result.svg') }}" alt="Results Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded hover:bg-[#E6E6E6] transition-colors duration-300">
            <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.28,1.27), transform 0.1s ease, color 0.1s ease;" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
                Results
            </span>
        </a>
        <a href="#" class="flex items-center justify-content group m-2 hover:bg-[#E6E6E6] rounded transition-background duration-100">
            <img src="{{ asset('assets/icons/ranking.svg') }}" alt="Faculty Ranking Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded hover:bg-[#E6E6E6] transition-colors duration-300">
            <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.28,1.27), transform 0.1s ease, color 0.1s ease;" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
                Faculty Ranking
            </span>
        </a>
    </div>
    
    <!-- Progress -->
    <a href="#" class="flex items-center justify-content group m-2 hover:bg-[#E6E6E6] rounded transition-background duration-100">
        <img src="{{ asset('assets/icons/monitor.svg') }}" alt="Progress Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded hover:bg-[#E6E6E6] transition-colors duration-300">
        <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.28,1.27), transform 0.1s ease, color 0.1s ease;" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
            Progress
        </span>
    </a>
    
    <!-- Sign-out -->
    <a href="#" class="flex items-center justify-content group m-2 hover:bg-[#E6E6E6] rounded transition-background duration-100">
        <img src="{{ asset('assets/icons/logout.svg') }}" alt="Sign-out Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded hover:bg-[#E6E6E6] transition-colors duration-300">
        <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.28,1.27), transform 0.1s ease, color 0.1s ease;" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
            Sign-out
        </span>
    </a>
</div>

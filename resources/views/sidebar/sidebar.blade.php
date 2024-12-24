<div class="border-r border-[#D4D4D4] bg-white text-[#666] font-semibold overflow-y-auto">
    <!-- Dashboard -->
    <a href="#" class="m-2 flex items-center justify-content group hover:bg-[#E6E6E6] rounded transition-background duration-100">
        <img src="{{ asset('assets/icons/home.svg') }}" alt="Dashboard Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded transition-colors duration-300">
        <span class="whitespace-nowrap overflow-hidden transition-all duration-300" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
            Dashboard
        </span>
    </a>
                
    <!-- Data Management -->
    <div>
        <a href="#" @click="showData = !showData" class="m-2 mb-0 flex items-center justify-content group hover:bg-[#E6E6E6] rounded transition-background duration-100">
            <img src="{{ asset('assets/icons/data.svg') }}" alt="Data Management Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded transition-colors duration-300">
            <span class="whitespace-nowrap overflow-hidden transition-all duration-300" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
                Data Management
            </span>
            <i x-show="showSidebar" class="fas fa-caret-right mr-2 transition-transform duration-200" :class="{'transform rotate-90': showData, 'transform rotate-0': !showData}"></i>
        </a>
    </div>
    <div x-show="showData" x-transition:enter="transition-all cubic-bezier(1,1,.59,1.01) duration-500" x-transition:enter-start="max-h-0" x-transition:enter-end="max-h-screen" x-transition:leave="transition-all cubic-bezier(1,1,.59,1.01) duration-500" x-transition:leave-start="max-h-screen" x-transition:leave-end="max-h-0" class="bg-[#F8F8F8] overflow-hidden transition-all duration-500 p-0">
        <!-- Nested Links -->
        @foreach ([
            'faculty' => ['label' => 'Faculty', 'link' => '#'],
            'student' => ['label' => 'Students', 'link' => '#'],
            'course' => ['label' => 'Courses', 'link' => '#'],
            'program' => ['label' => 'Programs', 'link' => '#'],
            'department' => ['label' => 'Departments', 'link' => '#'],
            'survey' => ['label' => 'Survey', 'link' => '#'],
            'section' => ['label' => 'Sections', 'link' => '#'],
            'account' => ['label' => 'Accounts', 'link' => '#']
        ] as $icon => $data)
            <a href="{{ $data['link'] }}" class="m-2 flex items-center justify-content group hover:bg-[#E6E6E6] rounded transition-background duration-100">
                <img src="{{ asset("assets/icons/{$icon}.svg") }}" alt="{{ $data['label'] }} Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded transition-colors duration-300">
                <span class="whitespace-nowrap overflow-hidden transition-all duration-300" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
                    {{ $data['label'] }}
                </span>
            </a>
        @endforeach
    </div>
    
    <!-- Evaluation -->
    <a href="#" class="m-2 flex items-center justify-content group hover:bg-[#E6E6E6] rounded transition-background duration-100">
        <img src="{{ asset('assets/icons/evaluation.svg') }}" alt="Evaluation Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded transition-colors duration-300">
        <span class="whitespace-nowrap overflow-hidden transition-all duration-300" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
            Evaluation
        </span>
    </a>
    
    <!-- Reports -->
    <a href="#" @click="showReport = !showReport" class="m-2 mb-0 flex items-center justify-content group hover:bg-[#E6E6E6] rounded transition-background duration-100">
        <img src="{{ asset('assets/icons/report.svg') }}" alt="Reports Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded transition-colors duration-300">
        <span class="whitespace-nowrap overflow-hidden transition-all duration-300" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
            Reports
        </span>
        <i x-show="showSidebar" class="fas fa-caret-right mr-2 transition-transform duration-200" :class="{'transform rotate-90': showReport, 'transform rotate-0': !showReport}"></i>
    </a>
    <div x-show="showReport" x-transition:enter="transition-all cubic-bezier(1,1,.59,1.01) duration-500" x-transition:enter-start="max-h-0" x-transition:enter-end="max-h-screen" x-transition:leave="transition-all cubic-bezier(1,1,.59,1.01) duration-500" x-transition:leave-start="max-h-screen" x-transition:leave-end="max-h-0" class="bg-[#F8F8F8] overflow-hidden transition-all duration-500">
        <!-- Nested Links -->
        @foreach ([
            'result' => ['label' => 'Results', 'link' => '#'],
            'ranking' => ['label' => 'Faculty Ranking', 'link' => '#'],
            'monitor' => ['label' => 'Progress', 'link' => '#']
        ] as $icon => $data)
            <a href="{{ $data['link'] }}" class="m-2 flex items-center justify-content group hover:bg-[#E6E6E6] rounded transition-background duration-100">
                <img src="{{ asset("assets/icons/{$icon}.svg") }}" alt="{{ $data['label'] }} Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded transition-colors duration-300">
                <span class="whitespace-nowrap overflow-hidden transition-all duration-300" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
                    {{ $data['label'] }}
                </span>
            </a>
        @endforeach
    </div>
    
    <!-- Sign-out -->
    <a href="#" class="m-2 flex items-center justify-content group hover:bg-[#E6E6E6] rounded transition-background duration-100">
        <img src="{{ asset('assets/icons/logout.svg') }}" alt="Sign-out Icon" class="min-w-10 min-h-10 flex items-center p-2 justify-center rounded transition-colors duration-300">
        <span class="whitespace-nowrap overflow-hidden transition-all duration-300" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
            Sign-out
        </span>
    </a>
</div>

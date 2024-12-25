<div class="z-50 h-full absolute lg:static transition-all duration-500 -left-16" x-bind:class="{'-left-0': showSidebar, '-left-16': !showSidebar}">
    <div class="font-TT border-r border-[#D4D4D4] bg-white text-[#666] overflow-y-auto h-full">
        
        <!-- Dashboard -->
        <x-nav-link href="{{ route('dashboard') }}" class="nav-btn group nav-btn-hover">
            <img src="{{ asset('assets/icons/home.svg') }}" alt="Dashboard Icon" class="icon">
            <span class="nav-text" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">Dashboard</span>
        </x-nav-link>
        
        <!-- Data Management -->
        <a href="#" @click="showData = !showData" class="nav-btn group nav-btn-hover" style="margin-bottom: 0;">
            <img src="{{ asset('assets/icons/data.svg') }}" alt="Data Management Icon" class="icon">
            <span class="nav-text" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">Data Management</span>
            <i x-show="showSidebar" class="fas fa-chevron-right mr-2 transition-transform duration-100" :class="{'transform rotate-90': showData, 'transform rotate-0': !showData}"></i>
        </a>

        <div x-show="showData" x-transition:enter="transition-all cubic-bezier(.74,.52,.25,1) duration-500" x-transition:enter-start="max-h-0" x-transition:enter-end="max-h-screen" x-transition:leave="transition-all cubic-bezier(.74,.52,.25,1) duration-500" x-transition:leave-start="max-h-screen" x-transition:leave-end="max-h-0" class="bg-[#F8F8F8] overflow-hidden p-0">
            <!-- Nested Links -->
            @foreach ([
                'faculty' => ['label' => 'Faculties', 'route' => 'faculties'],
                'student' => ['label' => 'Students', 'route' => 'students'],
                'course' => ['label' => 'Courses', 'route' => 'courses'],
                'program' => ['label' => 'Programs', 'route' => 'programs'],
                'department' => ['label' => 'Departments', 'route' => 'departments'],
                'survey' => ['label' => 'Survey', 'route' => 'survey'],
                'section' => ['label' => 'Sections', 'route' => 'sections'],
                'account' => ['label' => 'Accounts', 'route' => 'accounts']
            ] as $icon => $data)
                <a href="{{ route($data['route']) }}" class="nav-btn group nav-btn-hover">
                    <img src="{{ asset("assets/icons/{$icon}.svg") }}" alt="{{ $data['label'] }} Icon" class="icon">
                    <span class="nav-text" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">{{ $data['label'] }}</span>
                </a>
            @endforeach
        </div>
        
        <!-- Evaluation -->
        <a href="{{ route('evaluation') }}" class="nav-btn group nav-btn-hover">
            <img src="{{ asset('assets/icons/evaluation.svg') }}" alt="Evaluation Icon" class="icon">
            <span class="nav-text" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">Evaluation</span>
        </a>
        
        <!-- Reports -->
        <a href="#" @click="showReport = !showReport" class="nav-btn group nav-btn-hover" style="margin-bottom: 0;">
            <img src="{{ asset('assets/icons/report.svg') }}" alt="Reports Icon" class="icon">
            <span class="nav-text" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">Reports</span>
            <i x-show="showSidebar" class="fas fa-chevron-right mr-2 transition-transform duration-100" :class="{'transform rotate-90': showReport, 'transform rotate-0': !showReport}"></i>
        </a>
        <div x-show="showReport" x-transition:enter="transition-all cubic-bezier(.74,.52,.25,1) duration-500" x-transition:enter-start="max-h-0" x-transition:enter-end="max-h-screen" x-transition:leave="transition-all cubic-bezier(.74,.52,.25,1) duration-500" x-transition:leave-start="max-h-screen" x-transition:leave-end="max-h-0" class="bg-[#F8F8F8] overflow-hidden">
            <!-- Nested links -->
            @foreach ([
                'result' => ['label' => 'Results', 'route' => 'results'],
                'ranking' => ['label' => 'Faculty Ranking', 'route' => 'ranking'],
                'monitor' => ['label' => 'Progress', 'route' => 'monitor']
            ] as $icon => $data)
                <a href="{{ route($data['route']) }}" class="nav-btn group nav-btn-hover">
                    <img src="{{ asset("assets/icons/{$icon}.svg") }}" alt="{{ $data['label'] }} Icon" class="icon">
                    <span class="nav-text" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">{{ $data['label'] }}</span>
                </a>
            @endforeach
        </div>
        
        <!-- Sign-out -->
        <a href="#" class="nav-btn group nav-btn-hover">
            <img src="{{ asset('assets/icons/logout.svg') }}" alt="Sign-out Icon" class="icon">
            <span class="nav-text" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">Sign-out</span>
        </a>

    </div>
</div>
<div 
    x-bind:class="{'opacity-20': showSidebar, 'opacity-0': !showSidebar}"
    class="absolute z-10 w-full h-full transition-opacity duration-200 bg-black opacity-20 lg:hidden sm:block"
    x-on:click="showSidebar = false">
</div>
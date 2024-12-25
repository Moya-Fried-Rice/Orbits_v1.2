<div class="z-50 h-full absolute lg:static transition-all duration-500 -left-16" 
    x-bind:class="{'-left-0': showSidebar, '-left-16': !showSidebar}">
    <div class="font-TT border-r border-[#D4D4D4] bg-white text-[#666] overflow-y-auto h-full">

       <!-- Dashboard -->
       <x-nav-link :active="request()->routeIs('dashboard')" 
                :href="route('dashboard')" 
                :icon="asset('assets/icons/home.svg')">
          Dashboard
       </x-nav-link>
       
       <!-- Data Management -->
       <x-dropdown :icon="asset('assets/icons/data.svg')" 
                :active="in_array(request()->route()->getName(), ['faculties', 'students', 'courses', 'programs', 'departments', 'survey', 'sections', 'accounts'])">
          <x-slot name="trigger">
             Data Management
          </x-slot>

          <x-slot name="content"> 
             <!-- Faculties -->
             <x-dropdown-link :active="request()->routeIs('faculties')" 
                           :href="route('faculties')" 
                           :icon="asset('assets/icons/faculty.svg')">
                Faculties
             </x-dropdown-link>

             <!-- Students -->
             <x-dropdown-link :active="request()->routeIs('students')" 
                           :href="route('students')" 
                           :icon="asset('assets/icons/student.svg')">
                Students
             </x-dropdown-link>

             <!-- Courses -->
             <x-dropdown-link :active="request()->routeIs('courses')" 
                           :href="route('courses')" 
                           :icon="asset('assets/icons/course.svg')">
                Courses
             </x-dropdown-link>

             <!-- Programs -->
             <x-dropdown-link :active="request()->routeIs('programs')" 
                           :href="route('programs')" 
                           :icon="asset('assets/icons/program.svg')">
                Programs
             </x-dropdown-link>

             <!-- Departments -->
             <x-dropdown-link :active="request()->routeIs('departments')" 
                           :href="route('departments')" 
                           :icon="asset('assets/icons/department.svg')">
                Departments
             </x-dropdown-link>

             <!-- Survey -->
             <x-dropdown-link :active="request()->routeIs('survey')" 
                           :href="route('survey')" 
                           :icon="asset('assets/icons/survey.svg')">
                Survey
             </x-dropdown-link>

             <!-- Sections -->
             <x-dropdown-link :active="request()->routeIs('sections')" 
                           :href="route('sections')" 
                           :icon="asset('assets/icons/section.svg')">
                Sections
             </x-dropdown-link>

             <!-- Accounts -->
             <x-dropdown-link :active="request()->routeIs('accounts')" 
                           :href="route('accounts')" 
                           :icon="asset('assets/icons/account.svg')">
                Accounts
             </x-dropdown-link>
          </x-slot>
       </x-dropdown>

       <!-- Evaluation -->
       <x-nav-link :href="route('evaluation')" 
                :active="request()->routeIs('evaluation')" 
                :icon="asset('assets/icons/evaluation.svg')">
          Evaluation
       </x-nav-link>
       
       <!-- Reports -->
       <x-dropdown :icon="asset('assets/icons/report.svg')" 
                :active="in_array(request()->route()->getName(), ['results', 'ranking', 'monitor'])">
          <x-slot name="trigger">
             Reports
          </x-slot>

          <x-slot name="content"> 
             <!-- Results -->
             <x-dropdown-link :active="request()->routeIs('results')" 
                           :href="route('results')" 
                           :icon="asset('assets/icons/result.svg')">
                Results
             </x-dropdown-link>

             <!-- Faculty Ranking -->
             <x-dropdown-link :active="request()->routeIs('ranking')" 
                           :href="route('ranking')" 
                           :icon="asset('assets/icons/ranking.svg')">
                Faculty Ranking
             </x-dropdown-link>

             <!-- Progress -->
             <x-dropdown-link :active="request()->routeIs('monitor')" 
                           :href="route('monitor')" 
                           :icon="asset('assets/icons/monitor.svg')">
                Progress
             </x-dropdown-link>
          </x-slot>
       </x-dropdown>
       
       <!-- Sign-out -->
        <x-nav-link {{-- :href="route('dashboard')" 
                :active="request()->routeIs('dashboard')"  --}}
                :icon="asset('assets/icons/logout.svg')">
          Sign-out
       </x-nav-link>
    </div>
</div>


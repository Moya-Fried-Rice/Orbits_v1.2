<div class="z-20 h-full absolute lg:static transition-all duration-500 -left-16 overflow-hidden" 
    x-bind:class="{'-left-0': showSidebar, '-left-16': !showSidebar}">
    <div class="text-[#666] font-semibold border-r border-[#D4D4D4] bg-white overflow-y-auto h-full">

       <!-- Dashboard -->
      <x-nav-link 
         :active="request()->routeIs('dashboard')" 
         :href="route('dashboard')" 
         :icon="asset('assets/icons/home.svg')" 
         label="Dashboard"
      />
       
       <!-- Data Management -->
      <x-dropdown 
         :icon="asset('assets/icons/data.svg')" 
         show="showData"
         label="Data Management"
         :active="in_array(request()->route()->getName(), ['faculties', 'students', 'courses', 'programs', 'departments', 'survey', 'sections', 'accounts'])">
         <x-slot name="trigger">
         Data Management
         </x-slot>

         <x-slot name="content"> 
         <!-- Faculties -->
         <x-dropdown-link
            :active="request()->routeIs('faculties')" 
            :href="route('faculties')" 
            :icon="asset('assets/icons/faculty.svg')"
            label="Faculties"
         />

         <!-- Students -->
         <x-dropdown-link 
            :active="request()->routeIs('students')" 
            :href="route('students')" 
            :icon="asset('assets/icons/student.svg')"
            label="Students"
         />
         <!-- Courses -->
         <x-dropdown-link 
            :active="request()->routeIs('courses')" 
            :href="route('courses')" 
            :icon="asset('assets/icons/course.svg')"
            label="Courses"
         />

         <!-- Programs -->
         <x-dropdown-link 
            :active="request()->routeIs('programs')" 
            :href="route('programs')" 
            :icon="asset('assets/icons/program.svg')"
            label="Programs"
         />

         <!-- Departments -->
         <x-dropdown-link 
            :href="route('departments')" 
            :active="request()->routeIs('departments')" 
            :icon="asset('assets/icons/department.svg')"
            label="Departments"
         />

         <!-- Survey -->
         <x-dropdown-link 
            :active="request()->routeIs('survey')" 
            :href="route('survey')" 
            :icon="asset('assets/icons/survey.svg')"
            label="Survey"
         />

         <!-- Sections -->
         <x-dropdown-link 
            :active="request()->routeIs('sections')" 
            :href="route('sections')" 
            :icon="asset('assets/icons/section.svg')"
            label="Sections"
         />

         <!-- Accounts -->
         <x-dropdown-link 
            :active="request()->routeIs('accounts')" 
            :href="route('accounts')" 
            :icon="asset('assets/icons/account.svg')"
            label="Accounts"
         />
         </x-slot>

      </x-dropdown>

      <!-- Evaluation -->
      <x-nav-link 
         :href="route('evaluation')" 
         :active="request()->routeIs('evaluation')" 
         :icon="asset('assets/icons/evaluation.svg')"
         label="Evaluation"
      />
      
      <!-- Reports -->
      <x-dropdown 
         :icon="asset('assets/icons/report.svg')"
         show="showResults"
         label="Reports"
         :active="in_array(request()->route()->getName(), ['results', 'ranking', 'monitor'])">
         <x-slot name="trigger">
         Reports
         </x-slot>

         <x-slot name="content"> 
         <!-- Results -->
         <x-dropdown-link 
            :active="request()->routeIs('results')" 
            :href="route('results')" 
            :icon="asset('assets/icons/result.svg')"
            label="Results"
         />

         <!-- Faculty Ranking -->
         <x-dropdown-link 
            :active="request()->routeIs('ranking')" 
            :href="route('ranking')" 
            :icon="asset('assets/icons/ranking.svg')"
            label="Faculty Ranking"
         />

         <!-- Progress -->
         <x-dropdown-link 
            :active="request()->routeIs('monitor')" 
            :href="route('monitor')" 
            :icon="asset('assets/icons/monitor.svg')"
            label="Progress"
         />

         </x-slot>

      </x-dropdown>
      
      <!-- Logs -->
      <x-nav-link 
         :href="route('logs')" 
         :active="request()->routeIs('logs')" 
         :icon="asset('assets/icons/logs.svg')"
         label="Logs"
      />

      <!-- Sign-out -->
      <form method="POST" action="{{ route('logout') }}">
         @csrf
         <button type="submit" class="nav-btn group nav-btn-hover cursor-pointer flex items-center justify-start">
             <!-- Icon image -->
             <img src="{{ asset('assets/icons/logout.svg') }}" alt="Icon" class="icon">
             
             <!-- Navigation text with dynamic width based on 'showSidebar' -->
             <span class="nav-text text-left" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
                 Sign out
             </span>
             <x-tooltip label="Sign out" />
         </button>
     </form>

    </div>
</div>


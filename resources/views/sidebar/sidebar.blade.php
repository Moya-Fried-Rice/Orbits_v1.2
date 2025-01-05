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
         :active="in_array(request()->route()->getName(), ['faculties', 'students', 'courses', 'programs', 'departments', 'survey', 'sections', 'accounts'])">
         <x-slot name="trigger">
         Data Management
         </x-slot>

         <x-slot name="content"> 
         <!-- Faculties -->
         <x-dropdown-link
            {{-- :active="request()->routeIs('faculties')" 
            :href="route('faculties')"  --}}
            :icon="asset('assets/icons/faculty.svg')"
            label="Faculties"
         />

         <!-- Students -->
         <x-dropdown-link 
            {{-- :active="request()->routeIs('students')" 
            :href="route('students')"  --}}
            :icon="asset('assets/icons/student.svg')"
            label="Students"
         />
         <!-- Courses -->
         <x-dropdown-link 
            :active="request()->routeIs('courses.index')" 
            :href="route('courses.index')" 
            :icon="asset('assets/icons/course.svg')"
            label="Courses"
         />

         <!-- Programs -->
         <x-dropdown-link 
            {{-- :active="request()->routeIs('programs')" 
            :href="route('programs')"  --}}
            :icon="asset('assets/icons/program.svg')"
            label="Programs"
         />

         <!-- Departments -->
         <x-dropdown-link 
            {{-- :active="request()->routeIs('departments')" 
            :href="route('departments')"  --}}
            :icon="asset('assets/icons/department.svg')"
            label="Departments"
         />

         <!-- Survey -->
         <x-dropdown-link 
            {{-- :active="request()->routeIs('survey')" 
            :href="route('survey')"  --}}
            :icon="asset('assets/icons/survey.svg')"
            label="Survey"
         />

         <!-- Sections -->
         <x-dropdown-link 
            {{-- :active="request()->routeIs('sections')" 
            :href="route('sections')"  --}}
            :icon="asset('assets/icons/section.svg')"
            label="Sections"
         />

         <!-- Accounts -->
         <x-dropdown-link 
            {{-- :active="request()->routeIs('accounts')" 
            :href="route('accounts')"  --}}
            :icon="asset('assets/icons/account.svg')"
            label="Accounts"
         />
         </x-slot>

      </x-dropdown>

      <!-- Evaluation -->
      <x-nav-link 
         {{-- :href="route('evaluation')" 
         :active="request()->routeIs('evaluation')"  --}}
         :icon="asset('assets/icons/evaluation.svg')"
         label="Evaluation"
      />
      
      <!-- Reports -->
      <x-dropdown 
         :icon="asset('assets/icons/report.svg')"
         show="showResults"
         :active="in_array(request()->route()->getName(), ['results', 'ranking', 'monitor'])">
         <x-slot name="trigger">
         Reports
         </x-slot>

         <x-slot name="content"> 
         <!-- Results -->
         <x-dropdown-link 
            {{-- :active="request()->routeIs('results')" 
            :href="route('results')"  --}}
            :icon="asset('assets/icons/result.svg')"
            label="Results"
         />

         <!-- Faculty Ranking -->
         <x-dropdown-link 
            {{-- :active="request()->routeIs('ranking')" 
            :href="route('ranking')"  --}}
            :icon="asset('assets/icons/ranking.svg')"
            label="Faculty Ranking"
         />

         <!-- Progress -->
         <x-dropdown-link 
            {{-- :active="request()->routeIs('monitor')" 
            :href="route('monitor')"  --}}
            :icon="asset('assets/icons/monitor.svg')"
            label="Progress"
         />

         </x-slot>

      </x-dropdown>
      
      <!-- Sign-out -->
      <x-nav-link 
         {{-- :href="route('dashboard')" 
         :active="request()->routeIs('dashboard')"  --}}
         :icon="asset('assets/icons/logout.svg')"
         label="Sign-out"
      />
    </div>
</div>


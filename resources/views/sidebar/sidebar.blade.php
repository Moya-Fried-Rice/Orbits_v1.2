<div class="flex flex-col border-r-2 border-[#D4D4D4]">
    <div class="flex flex-col w-auto h-screen bg-white text-[#666] font-semibold">
        <div class="flex-1">
            <!-- Dashboard -->
            <div class="flex items-center p-2 m-3 mr-0 justify-content group">
                <img src="{{ asset('assets/icons/home.svg') }}" alt="Dashboard Icon" class="w-6 h-6 mr-3">
                <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.27,1.17);" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
                    Dashboard
                </span>
            </div>
                     
            
            <!-- Data Management -->
            <div class="flex items-center p-2 m-3 mr-0 justify-content relative">
                <img src="{{ asset('assets/icons/data.svg') }}" alt="Data Management Icon" class="w-6 h-6 mr-3">
                <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.27,1.17);" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
                    Data Management
                </span>
                <i x-show="showSidebar" class="fas fa-caret-right"></i>
            </div>
            
            <!-- Evaluation -->
            <div class="flex items-center p-2 m-3 mr-0 justify-content">
                <img src="{{ asset('assets/icons/evaluation.svg') }}" alt="Evaluation Icon" class="w-6 h-6 mr-3">
                <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.27,1.17);" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
                    Evaluation
                </span>
            </div>
            
            <!-- Reports -->
            <div class="flex items-center p-2 m-3 mr-0 justify-content relative">
                <img src="{{ asset('assets/icons/report.svg') }}" alt="Reports Icon" class="w-6 h-6 mr-3">
                <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.27,1.17);" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
                    Reports
                </span>
                <i x-show="showSidebar" class="fas fa-caret-right"></i>
            </div>
            
            <!-- Progress -->
            <div class="flex items-center p-2 m-3 mr-0 justify-content">
                <img src="{{ asset('assets/icons/monitor.svg') }}" alt="Progress Icon" class="w-6 h-6 mr-3">
                <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.27,1.17);" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
                    Progress
                </span>
            </div>
            
            <!-- Sign-out -->
            <div class="flex items-center p-2 m-3 mr-0 justify-content">
                <img src="{{ asset('assets/icons/logout.svg') }}" alt="Sign-out Icon" class="w-6 h-6 mr-3">
                <span class="whitespace-nowrap overflow-hidden" style="transition: width 0.3s cubic-bezier(.67,.61,.27,1.17);" x-bind:class="{'w-44': showSidebar, 'w-0': !showSidebar}">
                    Sign-out
                </span>
            </div>
        </div>
    </div>
</div>
<div class="font-TT flex bg-white justify-between border-b border-[#D4D4D4]" style="flex">
</div>

<div class="grid bg-white 
    sm:grid-cols-3 
    sm:grid-rows-1 
    md:grid-cols-2 
    lg:grid-cols-2 
    xl:grid-cols-2 
    md:grid-rows-2 
    lg:grid-rows-2 
    xl:grid-rows-2 
    grid-cols-3 
    grid-rows-1">
    
    <!-- Third div (blue) comes first on sm -->
    <div class="border-b border-[#D4D4D4]
        order-1 
        sm:order-1 
        md:order-3 
        lg:order-3 
        xl:order-3 
        col-span-1 
        md:col-span-2 
        lg:col-span-2
        xl:col-span-2">
        
        <div x-cloak>
            <button
                @click="showSidebar = !showSidebar"  
                :class="{'transform rotate-90': showSidebar, 'transform rotate-0': !showSidebar}" 
                style="transition: transform 0.2s cubic-bezier(.67, .61, .28, 1.27);"
                class="nav-btn nav-btn-hover">     
                <img src="{{ asset('assets/icons/menu.svg') }}" alt="Menu Icon" class="icon">
            </button>
        </div>
    </div>

    <!-- First div (red) -->
    <div class="flex items-center justify-start border-b border-[#D4D4D4]
        justify-center
        sm:justify-center
        md:justify-start
        lg:justify-start
        xl:justify-start
        order-2 
        sm:order-2 
        md:order-1 
        lg:order-1 
        xl:order-1 
        col-span-1">
        
        <div>
            <img src="{{ asset('assets/logo/logo-sided.png') }}" alt="Dashboard Icon" class="h-10 sm:ml-0 md:ml-2 lg:ml-2 xl:ml-2 ml-0">   
        </div>
    </div>

    <!-- Second div (lime) -->
    <div class="z-100 flex items-center justify-end text-[#666] border-b border-[#D4D4D4]
        order-3 
        sm:order-3 
        md:order-2 
        lg:order-2 
        xl:order-2 
        col-span-1">
        
        <div x-data="{ open: false }">
            <div class="relative">
                <button @click="open = !open" class="flex items-center justify-center mr-2 relative">
                    <span class="mr-2">Cj Rojo</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div    
                    x-show="open" @click.away="open = false" 
                    x-transition:enter="transition ease-out duration-200" 
                    x-transition:enter-start="opacity-0 transform -translate-y-4" 
                    x-transition:enter-end="opacity-100 transform translate-y-0" 
                    x-transition:leave="transition ease-in duration-150" 
                    x-transition:leave-start="opacity-100 transform translate-y-0" 
                    x-transition:leave-end="opacity-0 transform -translate-y-4" 
                    class="absolute right-2 mt-2 border w-28 bg-white rounded z-50">
                    <a href="#" class="block px-6 py-2 text-[#666] hover:bg-gray-100">Profile</a>
                    <a href="#" class="block px-6 py-2 text-[#666] hover:bg-gray-100">Settings</a>
                    <a href="#" class="block px-6 py-2 text-[#666] hover:bg-gray-100">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

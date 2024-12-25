<div class="font-TT flex bg-white justify-between border-b border-[#D4D4D4]"  style="flex">
    <div class="flex items-center p-3 justify-center ">
        <img src="{{ asset('assets/logo/logo-sided.png') }}" alt="Dashboard Icon" class="h-12">   
    </div>
    <div x-data="{ open: false }" class="relative z-100 flex items-center p-3 mr-10 justify-center text-[#666]">
        <button @click="open = !open" class="flex items-center p-3 justify-center">
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
        class="absolute top-12 left-0 mt-2 border w-28 bg-white rounded z-50"
        >
            <a href="#" class="block px-6 py-2 text-[#666] hover:bg-gray-100">Profile</a>
            <a href="#" class="block px-6 py-2 text-[#666] hover:bg-gray-100">Settings</a>
            <a href="#" class="block px-6 py-2 text-[#666] hover:bg-gray-100">Logout</a>
        </div>
    </div>
</div>

<div class="flex bg-white border-b border-[#D4D4D4] text-[#666] font-semibold">

    <button 
    x-on:click="showSidebar = !showSidebar"  
    x-on:click="showMobile = !showMobile"
    
    :class="{'transform rotate-90': showSidebar, 'transform rotate-0': !showSidebar}" 
    style="transition: transform 0.2s cubic-bezier(.67, .61, .28, 1.27);" 
    class="nav-btn nav-btn-hover" >
            <img src="{{ asset('assets/icons/menu.svg') }}" alt="Menu Icon" class="icon">
    </button>

</div>


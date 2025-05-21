<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome-free-6.7.2-web/css/all.min.css') }}">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @livewireStyles

    @yield('title')
    
</head>
<body class="bg-gray-100 m-0 p-0" x-data="{ showSidebar: false, showData: false, showResults: false }" x-cloak>

    <div class="flex flex-col h-screen">
        <!-- Navigation content (Navbar) -->
        @include('navbar.navbar')
        
        <!-- Main content area -->
        <div class="flex flex-1 overflow-hidden relative">

            <!-- Click outside to close when mobile view -->
            <div 
                @click="showSidebar = false"
                x-bind:class="{
                    'opacity-20': showSidebar,
                    'opacity-0': !showSidebar,
                    'pointer-events-auto': showSidebar,
                    'pointer-events-none': !showSidebar
                }"
                class="absolute z-10 w-full h-full transition-opacity duration-200 bg-black lg:hidden sm:block">
            </div>
        
            <!-- Sidebar -->
            @include('sidebar.sidebar')
            
            <!-- Main content (flex-1 ensures it takes the remaining space) -->
            <div class="w-full flex-1 overflow-auto relative">
                <div class="w-full h-full p-5 overflow-auto text-[#666]" x-data="{ scrollPosition: 0 }" x-init="
                $el.addEventListener('scroll', () => {
                    scrollPosition = $el.scrollTop;
                });">
                    @yield('content')
                    <span class="text-xs opacity-50 flex justify-center p-2">
                       Copyright © 2025 Orbits v1.1.0 - Supernova. All rights reserved.
                    </span>
                </div>
            </div>
        </div>
        
        
    </div>

    @livewireScripts
    @yield('scripts')
    
</body>
</html>

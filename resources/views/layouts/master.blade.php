<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome-free-6.7.2-web/css/all.min.css') }}">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="relative bg-gray-100 m-0 p-0" x-data="{ showSidebar: false, showData: false }" x-cloak>

    <div class="flex flex-col h-screen">
        <!-- Navigation content (Navbar) -->
        @include('navbar.navbar')
        
        <!-- Main content area -->
        <div class="flex flex-1 overflow-hidden relative">

            <!-- Click outside to close when mobile view -->
            <div 
                @click="showSidebar = false"
                x-bind:class="{'opacity-20': showSidebar, 'opacity-0': !showSidebar}"
                class="absolute z-10 w-full h-full transition-opacity duration-200 bg-black opacity-20 lg:hidden sm:block">
            </div>

            <!-- Sidebar -->
            @include('sidebar.sidebar')
            
            <!-- Main content (flex-1 ensures it takes the remaining space) -->
            <div class="w-full h-full p-5 flex-1 overflow-auto">
                <div class="w-full h-full rounded bg-white text-[#666] font-semibold overflow-y-auto">
                    @yield('content')
                </div>
            </div>
        </div>
        
    </div>
    
    @yield('scripts')

</body>
</html>

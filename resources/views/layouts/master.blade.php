<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/font/fontawesome-free-6.7.2-web/css/all.min.css') }}">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100 m-0 p-0">
    <div x-data="{ showSidebar: true }" class="flex flex-col h-screen">
        <div class="flex flex-col h-full">

            <!-- Navigation content (Navbar) -->
            @include('navbar.navbar')

            <!-- Main content area -->
            <div class="flex flex-1 overflow-hidden">
                <!-- Sidebar -->
                @include('sidebar.sidebar')

                <!-- Main content (flex-1 ensures it takes the remaining space) -->
                <div class="flex-1 overflow-auto">
                        <div class="w-full h-full p-5">
                                <div class="w-full h-full rounded bg-white text-[#666] font-semibold overflow-y-auto">
                                         @yield('content')
                                </div>
                        </div>
                </div>
            </div>

        </div>
    </div>

    @yield('scripts')
</body>
</html>

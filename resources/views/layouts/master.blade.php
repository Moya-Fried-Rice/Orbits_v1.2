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
        @include('navbar.navbar')
        <div class="flex h-screen">
                @include('sidebar.sidebar')
                <!-- Main content -->
                <div class="flex-1 p-4 overflow-auto">
                        @yield('content')
                </div>
        </div>
        @yield('scripts')
</body>
</html>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  @vite('resources/js/app.js')
</head>
<body>
    <div x-data="{ open: false, dropdownOpen: false }" class="flex h-screen">
        <!-- Sidebar -->
        <div :class="open ? 'block' : 'hidden'" class="fixed inset-0 bg-gray-600 bg-opacity-75 transition-opacity lg:hidden"></div>
        <div :class="open ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg transform transition-transform lg:translate-x-0 lg:static lg:inset-0">
            <div class="flex items-center justify-between p-4">
                <h2 class="text-lg font-semibold">Sidebar</h2>
                <button @click="open = false" class="lg:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <nav class="p-4">
                <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-200 rounded">Dashboard</a>
                <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-200 rounded">Profile</a>
                <div @click.away="dropdownOpen = false" class="relative">
                    <button @click="dropdownOpen = !dropdownOpen" class="block w-full py-2 px-4 text-gray-700 hover:bg-gray-200 rounded">
                        Settings
                        <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="dropdownOpen" class="absolute left-0 w-full mt-2 bg-white shadow-lg rounded">
                        <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-200 rounded">Sub-item 1</a>
                        <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-200 rounded">Sub-item 2</a>
                        <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-200 rounded">Sub-item 3</a>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Main content -->
        <div class="flex-1 p-4">
            <button @click="open = true" class="lg:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <div>
                <!-- Main content goes here -->
                <div class="p-10 max-w-sm mx-auto bg-white rounded-xl shadow-lg flex" x-data="{ showMessage: false }">
                    <div>
                      <div class="text-xl font-medium text-black">ChitChat</div>
                      <p class="text-slate-500">You have a new message!</p>
                      <button @click="showMessage = !showMessage" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Toggle Message</button>
                      <p x-show="showMessage" class="mt-2 text-green-500">This is a toggled message!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
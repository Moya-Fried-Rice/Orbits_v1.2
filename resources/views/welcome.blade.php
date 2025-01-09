<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome-free-6.7.2-web/css/all.min.css') }}">
  @vite('resources/css/app.css')
  @vite('resources/js/app.js')
  @livewireStyles
</head>
<body background="{{ asset('assets/images/background.png') }}"
style="background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="font-TT text-[#666] min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full bg-white p-8 border border-[#DDD] rounded-lg shadow-lg">
            <div class="w-full flex justify-center">
                <img src="{{ asset('assets/logo/logo-sided.png') }}" class="h-20" alt="logo">
            </div>
            <div class="mb-6 mt-6 text-center">
                <h2 class="text-2xl">Welcome Back, Lycean!</h2>
                <p class="text-sm text-gray-500">Log in to your account</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <b>Whoops!</b>
                    
                    {{-- Display the email error message --}}
                    @if ($errors->has('email'))
                        <span class="block sm:inline">{{ $errors->first('email') }}</span>
                    @endif
                    
                    {{-- Display the password error message --}}
                    @if ($errors->has('password'))
                        <span class="block sm:inline">{{ $errors->first('password') }}</span>
                    @endif
                </div>
            @endif
        
            <form action="{{ route('login') }}" method="POST" autocomplete="off">
                @csrf
                <div class="mb-4 group">
                    <label for="email" class="block text-sm">Email</label>
                    <input type="email" id="email" name="email" placeholder="ilovepizza@nomnom.com"
                    class="focus:ring focus:ring-blue-300 px-5 py-2 border border-[#DDD] rounded appearance-none w-full bg-[#F8F8F8] transition-all duration-200 group-hover:border-[#923534] text-sm">
                </div>
                <div class="mb-6 group">
                    <label for="password" class="block text-sm">Password</label>
                    <input type="password" id="password" name="password" placeholder="Shhh... It's a secret!"
                    class="focus:ring focus:ring-blue-300 px-5 py-2 border border-[#DDD] rounded appearance-none w-full bg-[#F8F8F8] transition-all duration-200 group-hover:border-[#923534] text-sm">
                </div>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" 
                        class="h-4 w-4 text-[#923534]">
                        <label for="remember" class="ml-2 block text-sm">Remember me</label>
                    </div>
                    <a href="#" class="text-sm text-[#923534] hover:underline">Forgot password?</a>
                </div>
                <button type="submit" 
                class="w-full text-sm cursor-pointer transition duration-100 bg-[#923534] text-white px-4 py-2 rounded hover:bg-[#7B2323] focus:outline-none focus:ring-2 focus:ring-red-300">
                Login
                </button>
            </form>            
        </div>
    </div>
</body>
</html>

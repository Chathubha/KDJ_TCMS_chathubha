<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In - {{ config('app.name', 'TCMS') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">

    <div class="min-h-screen flex">
        {{-- Left Panel --}}
        <div class="hidden lg:flex lg:w-[45%] bg-gray-900 relative overflow-hidden items-center justify-center p-12">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-10 left-10 w-72 h-72 bg-indigo-500 rounded-full blur-3xl"></div>
                <div class="absolute bottom-10 right-10 w-72 h-72 bg-purple-500 rounded-full blur-3xl"></div>
            </div>
            <div class="relative z-10 max-w-md">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 mb-12">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <span class="text-white text-sm font-extrabold">T</span>
                    </div>
                    <span class="text-xl font-extrabold text-white tracking-tight">TCMS</span>
                </a>

                <h1 class="text-4xl font-black text-white leading-tight mb-5">Welcome Back to<br><span class="text-indigo-400">Class Management</span></h1>
                <p class="text-gray-400 text-lg leading-relaxed mb-10">Sign in to manage attendance, grades, schedules, and student records.</p>

                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <span class="text-gray-300 text-sm">Track attendance for all classes</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <span class="text-gray-300 text-sm">Manage grades and report cards</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <span class="text-gray-300 text-sm">Build timetables with conflict detection</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Panel --}}
        <div class="w-full lg:w-[55%] flex items-center justify-center p-6 sm:p-12 bg-white">
            <div class="w-full max-w-md">
                <a href="{{ url('/') }}" class="lg:hidden flex items-center gap-2.5 mb-8">
                    <div class="w-9 h-9 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <span class="text-white text-sm font-extrabold">T</span>
                    </div>
                    <span class="text-lg font-extrabold text-gray-900">TCMS</span>
                </a>

                <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Sign In</h2>
                <p class="text-gray-500 mb-8">Enter your credentials to continue</p>

                @if (session('status'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white outline-none transition"
                               placeholder="you@example.com">
                        @error('email') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white outline-none transition"
                               placeholder="••••••••">
                        @error('password') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-sm text-gray-600">Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500 transition">Forgot password?</a>
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-gray-900 hover:bg-gray-800 text-white font-bold py-3.5 px-6 rounded-xl transition shadow-lg shadow-gray-900/10 hover:shadow-xl focus:ring-4 focus:ring-gray-200">
                        Sign In
                    </button>
                </form>

                <p class="mt-8 text-center text-sm text-gray-500">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-semibold text-gray-900 hover:text-indigo-600 transition">Create one</a>
                </p>
                <p class="mt-3 text-center">
                    <a href="{{ url('/') }}" class="text-sm text-gray-400 hover:text-gray-600 transition">← Back to home</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log In - {{ config('app.name', 'TCMS') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .auth-gradient { background: linear-gradient(135deg, #1e1b4b 0%, #312e81 30%, #4338ca 60%, #6366f1 100%); }
        .glass-card { background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex">
        {{-- Left Panel — Branding --}}
        <div class="hidden lg:flex lg:w-1/2 auth-gradient relative overflow-hidden">
            <div class="absolute inset-0">
                <div class="absolute top-20 left-20 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
                <div class="absolute bottom-20 right-20 w-64 h-64 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
            </div>
            <div class="relative z-10 flex flex-col justify-center px-12 text-white">
                <div class="flex items-center space-x-3 mb-10">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <span class="text-2xl">🎓</span>
                    </div>
                    <span class="text-2xl font-bold">TCMS</span>
                </div>
                <h1 class="text-4xl font-extrabold leading-tight mb-6">Welcome Back to<br><span class="text-indigo-200">Class Management</span></h1>
                <p class="text-lg text-indigo-200 leading-relaxed mb-10 max-w-md">Manage attendance, grades, schedules, and student records. Your complete school management solution.</p>
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <span class="text-indigo-100">Track attendance for all classes</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <span class="text-indigo-100">Manage grades and report cards</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <span class="text-indigo-100">Build timetables with conflict detection</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Panel — Login Form --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 bg-gray-50">
            <div class="w-full max-w-md">
                {{-- Mobile Logo --}}
                <div class="lg:hidden flex items-center space-x-2 mb-8">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center">
                        <span class="text-white text-lg font-bold">🎓</span>
                    </div>
                    <span class="text-xl font-bold text-gray-900">TCMS</span>
                </div>

                <div class="mb-8">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Sign In</h2>
                    <p class="text-gray-500">Enter your credentials to access your account</p>
                </div>

                {{-- Status Message --}}
                @if (session('status'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                               class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                               placeholder="you@example.com">
                        @error('email')
                            <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                               placeholder="••••••••">
                        @error('password')
                            <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember + Forgot --}}
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl transition shadow-lg shadow-indigo-200 hover:shadow-xl focus:ring-4 focus:ring-indigo-300">
                        Sign In
                    </button>
                </form>

                {{-- Register Link --}}
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 transition">Create one</a>
                    </p>
                </div>

                {{-- Back to Home --}}
                <div class="mt-4 text-center">
                    <a href="{{ url('/') }}" class="text-sm text-gray-400 hover:text-gray-600 transition">← Back to home</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

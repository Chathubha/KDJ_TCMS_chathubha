<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - {{ config('app.name', 'TCMS') }}</title>
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
                <div class="absolute top-20 right-20 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
                <div class="absolute bottom-20 left-20 w-64 h-64 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
            </div>
            <div class="relative z-10 flex flex-col justify-center px-12 text-white">
                <div class="flex items-center space-x-3 mb-10">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <span class="text-2xl">🎓</span>
                    </div>
                    <span class="text-2xl font-bold">TCMS</span>
                </div>
                <h1 class="text-4xl font-extrabold leading-tight mb-6">Start Managing<br><span class="text-indigo-200">Your School Today</span></h1>
                <p class="text-lg text-indigo-200 leading-relaxed mb-10 max-w-md">Create your free account and get instant access to all modules — students, teachers, attendance, grades, and more.</p>

                {{-- Stats --}}
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center border border-white/10">
                        <div class="text-2xl font-bold">8</div>
                        <div class="text-xs text-indigo-200">Modules</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center border border-white/10">
                        <div class="text-2xl font-bold">3</div>
                        <div class="text-xs text-indigo-200">User Roles</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center border border-white/10">
                        <div class="text-2xl font-bold">100%</div>
                        <div class="text-xs text-indigo-200">Free</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Panel — Register Form --}}
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
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Create Account</h2>
                    <p class="text-gray-500">Fill in the details to get started</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                               class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                               placeholder="John Doe">
                        @error('name')
                            <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                               class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                               placeholder="you@example.com">
                        @error('email')
                            <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                               class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                               placeholder="••••••••">
                        @error('password')
                            <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                               class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                               placeholder="••••••••">
                        @error('password_confirmation')
                            <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl transition shadow-lg shadow-indigo-200 hover:shadow-xl focus:ring-4 focus:ring-indigo-300">
                        Create Account
                    </button>
                </form>

                {{-- Login Link --}}
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 transition">Sign in</a>
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

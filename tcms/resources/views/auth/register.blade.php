<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account - {{ config('app.name', 'TCMS') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">

    <div class="min-h-screen flex">
        {{-- Left Panel --}}
        <div class="hidden lg:flex lg:w-[45%] bg-gray-900 relative overflow-hidden items-center justify-center p-12">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-10 right-10 w-72 h-72 bg-indigo-500 rounded-full blur-3xl"></div>
                <div class="absolute bottom-10 left-10 w-72 h-72 bg-purple-500 rounded-full blur-3xl"></div>
            </div>
            <div class="relative z-10 max-w-md">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 mb-12">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <span class="text-white text-sm font-extrabold">T</span>
                    </div>
                    <span class="text-xl font-extrabold text-white tracking-tight">TCMS</span>
                </a>

                <h1 class="text-4xl font-black text-white leading-tight mb-5">Start Managing<br><span class="text-indigo-400">Your School Today</span></h1>
                <p class="text-gray-400 text-lg leading-relaxed mb-10">Create your free account and get instant access to all modules.</p>

                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-white/5 backdrop-blur-sm rounded-xl p-4 text-center border border-white/10">
                        <div class="text-2xl font-extrabold text-white">8</div>
                        <div class="text-xs text-gray-400 mt-1">Modules</div>
                    </div>
                    <div class="bg-white/5 backdrop-blur-sm rounded-xl p-4 text-center border border-white/10">
                        <div class="text-2xl font-extrabold text-white">3</div>
                        <div class="text-xs text-gray-400 mt-1">User Roles</div>
                    </div>
                    <div class="bg-white/5 backdrop-blur-sm rounded-xl p-4 text-center border border-white/10">
                        <div class="text-2xl font-extrabold text-white">100%</div>
                        <div class="text-xs text-gray-400 mt-1">Free</div>
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

                <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Create Account</h2>
                <p class="text-gray-500 mb-8">Fill in your details to get started</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white outline-none transition"
                               placeholder="John Doe">
                        @error('name') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white outline-none transition"
                               placeholder="you@example.com">
                        @error('email') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white outline-none transition"
                               placeholder="••••••••">
                        @error('password') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white outline-none transition"
                               placeholder="••••••••">
                        @error('password_confirmation') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full bg-gray-900 hover:bg-gray-800 text-white font-bold py-3.5 px-6 rounded-xl transition shadow-lg shadow-gray-900/10 hover:shadow-xl focus:ring-4 focus:ring-gray-200">
                        Create Account
                    </button>
                </form>

                <p class="mt-8 text-center text-sm text-gray-500">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-semibold text-gray-900 hover:text-indigo-600 transition">Sign in</a>
                </p>
                <p class="mt-3 text-center">
                    <a href="{{ url('/') }}" class="text-sm text-gray-400 hover:text-gray-600 transition">← Back to home</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>

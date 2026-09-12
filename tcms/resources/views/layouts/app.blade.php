<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TCMS') }} - @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">

        {{-- Mobile Overlay --}}
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 z-30 bg-gray-900/50 lg:hidden"></div>

        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-40 w-64 bg-gray-900 transform transition-transform duration-300 lg:translate-x-0 lg:static lg:z-auto flex flex-col">

            {{-- Logo --}}
            <div class="flex items-center justify-center h-16 border-b border-gray-800">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-600 rounded-xl flex items-center justify-center">
                        <span class="text-white text-sm font-bold">TC</span>
                    </div>
                    <span class="text-lg font-bold text-white tracking-tight">TCMS</span>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                <p class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Main</p>

                <a href="{{ route('dashboard') }}"
                   class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition {{ request()->routeIs('dashboard') ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-400 hover:text-white hover:bg-white/10' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>

                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'teacher')
                <p class="px-3 pt-5 pb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Management</p>

                <a href="{{ route('students.index') }}"
                   class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition {{ request()->routeIs('students.*') ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-400 hover:text-white hover:bg-white/10' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                    Students
                </a>

                <a href="{{ route('teachers.index') }}"
                   class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition {{ request()->routeIs('teachers.*') ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-400 hover:text-white hover:bg-white/10' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Teachers
                </a>

                <a href="{{ route('classrooms.index') }}"
                   class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition {{ request()->routeIs('classrooms.*') ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-400 hover:text-white hover:bg-white/10' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Classes
                </a>

                <a href="{{ route('subjects.index') }}"
                   class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition {{ request()->routeIs('subjects.*') ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-400 hover:text-white hover:bg-white/10' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Subjects
                </a>

                <p class="px-3 pt-5 pb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Academics</p>

                <a href="{{ route('attendance.index') }}"
                   class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition {{ request()->routeIs('attendance.*') ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-400 hover:text-white hover:bg-white/10' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    Attendance
                </a>

                <a href="{{ route('grades.index') }}"
                   class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition {{ request()->routeIs('grades.*') ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-400 hover:text-white hover:bg-white/10' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Grades
                </a>

                <a href="{{ route('schedule.index') }}"
                   class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition {{ request()->routeIs('schedule.*') ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-400 hover:text-white hover:bg-white/10' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Schedule
                </a>
                @endif
            </nav>

            {{-- User Section --}}
            <div class="p-3 border-t border-gray-800">
                <div class="flex items-center gap-3 px-2 py-2 rounded-xl hover:bg-white/5 transition cursor-pointer"
                     x-data="{ open: false }" @click="open = !open">
                    <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center text-sm font-bold text-white shrink-0">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-500 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                <div x-show="open" x-transition class="mt-1 py-1 bg-gray-800 rounded-xl">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg mx-1">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg mx-1">Log Out</button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-h-screen">
            {{-- Top Navbar --}}
            <header class="bg-white border-b border-gray-100 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 shrink-0">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-xl text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div class="flex-1 flex justify-center px-4">
                    <form method="GET" action="{{ route('search') }}" class="w-full max-w-md">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" name="q" placeholder="Search students, teachers, classes..." value="{{ request('q') }}"
                                   class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition">
                        </div>
                    </form>
                </div>

                <div class="flex items-center gap-3">
                    <span class="hidden sm:inline text-sm text-gray-500">{{ now()->format('M d, Y') }}</span>
                    <div class="w-9 h-9 rounded-full bg-gray-900 flex items-center justify-center text-sm font-bold text-white lg:hidden">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @if(session('success'))
                    <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl p-4 text-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                @endif

                @if(isset($header))
                    <div class="mb-6">
                        {{ $header }}
                    </div>
                @endif

                {{ $slot }}
            </main>

            {{-- Footer --}}
            <footer class="bg-white border-t border-gray-100 py-4 px-6 text-center text-sm text-gray-400">
                {{ now()->year }} TCMS &mdash; Class Management System
            </footer>
        </div>
    </div>
</body>
</html>

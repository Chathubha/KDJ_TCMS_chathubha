<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'TCMS') }} - Class Management System</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-gray-900">

    {{-- Navbar --}}
    <nav class="fixed top-0 inset-x-0 z-50 bg-white/70 backdrop-blur-xl border-b border-gray-100/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                    <div class="w-9 h-9 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200 group-hover:shadow-indigo-300 transition-shadow">
                        <span class="text-white text-sm font-extrabold">T</span>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-gray-900">TCMS</span>
                </a>
                <div class="hidden md:flex items-center gap-8">
                    <a href="#features" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition">Features</a>
                    <a href="#modules" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition">Modules</a>
                    <a href="#steps" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition">How It Works</a>
                </div>
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-gray-900 hover:bg-gray-800 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition shadow-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 px-3 py-2 transition">Sign In</a>
                        <a href="{{ route('register') }}" class="bg-gray-900 hover:bg-gray-800 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition shadow-sm">Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-32 overflow-hidden">
        {{-- Background decorations --}}
        <div class="absolute inset-0 -z-10">
            <div class="absolute top-0 right-1/4 w-96 h-96 bg-indigo-100 rounded-full blur-3xl opacity-60"></div>
            <div class="absolute bottom-0 left-1/4 w-80 h-80 bg-purple-100 rounded-full blur-3xl opacity-50"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto">
                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 bg-indigo-50 border border-indigo-100 text-indigo-700 text-sm font-semibold px-4 py-2 rounded-full mb-8">
                    <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
                    Class Management System
                </div>

                {{-- Heading --}}
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-[1.1] mb-6">
                    Manage Your School
                    <span class="block bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 bg-clip-text text-transparent">Smarter, Not Harder</span>
                </h1>

                {{-- Subtext --}}
                <p class="text-lg sm:text-xl text-gray-500 leading-relaxed mb-10 max-w-2xl mx-auto">
                    A complete class management system for schools and colleges. Track attendance, manage grades, build timetables, and monitor student performance — all in one place.
                </p>

                {{-- CTA Buttons --}}
                <div class="flex flex-wrap items-center justify-center gap-4 mb-12">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-gray-900 hover:bg-gray-800 text-white px-8 py-3.5 rounded-2xl font-bold text-base transition shadow-lg shadow-gray-900/10 hover:shadow-xl hover:shadow-gray-900/20">
                            Go to Dashboard →
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-gray-900 hover:bg-gray-800 text-white px-8 py-3.5 rounded-2xl font-bold text-base transition shadow-lg shadow-gray-900/10 hover:shadow-xl hover:shadow-gray-900/20">
                            Get Started Free →
                        </a>
                        <a href="{{ route('login') }}" class="bg-white border-2 border-gray-200 text-gray-700 hover:border-gray-300 hover:bg-gray-50 px-8 py-3.5 rounded-2xl font-bold text-base transition">
                            Sign In
                        </a>
                    @endauth
                </div>

                {{-- Stats Row --}}
                <div class="flex items-center justify-center gap-8 sm:gap-12">
                    <div class="text-center">
                        <p class="text-2xl font-extrabold text-gray-900">30+</p>
                        <p class="text-sm text-gray-500 font-medium">Students</p>
                    </div>
                    <div class="w-px h-10 bg-gray-200"></div>
                    <div class="text-center">
                        <p class="text-2xl font-extrabold text-gray-900">10+</p>
                        <p class="text-sm text-gray-500 font-medium">Teachers</p>
                    </div>
                    <div class="w-px h-10 bg-gray-200"></div>
                    <div class="text-center">
                        <p class="text-2xl font-extrabold text-gray-900">8</p>
                        <p class="text-sm text-gray-500 font-medium">Classes</p>
                    </div>
                    <div class="w-px h-10 bg-gray-200"></div>
                    <div class="text-center">
                        <p class="text-2xl font-extrabold text-gray-900">8</p>
                        <p class="text-sm text-gray-500 font-medium">Modules</p>
                    </div>
                </div>
            </div>

            {{-- Hero Preview Card --}}
            <div class="mt-16 max-w-4xl mx-auto">
                <div class="relative">
                    <div class="absolute -inset-4 bg-gradient-to-r from-indigo-200 via-purple-200 to-pink-200 rounded-3xl blur-xl opacity-50"></div>
                    <div class="relative bg-white rounded-2xl shadow-2xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
                        <div class="flex items-center gap-2 px-5 py-3 border-b border-gray-100 bg-gray-50/50">
                            <div class="w-3 h-3 rounded-full bg-red-400"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                            <div class="w-3 h-3 rounded-full bg-green-400"></div>
                            <span class="ml-3 text-xs font-medium text-gray-400">TCMS Dashboard</span>
                        </div>
                        <div class="p-6 sm:p-8">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                                <div class="bg-blue-50 rounded-xl p-4 text-center border border-blue-100">
                                    <p class="text-2xl font-extrabold text-blue-700">30</p>
                                    <p class="text-xs font-medium text-blue-500 mt-1">Students</p>
                                </div>
                                <div class="bg-green-50 rounded-xl p-4 text-center border border-green-100">
                                    <p class="text-2xl font-extrabold text-green-700">10</p>
                                    <p class="text-xs font-medium text-green-500 mt-1">Teachers</p>
                                </div>
                                <div class="bg-amber-50 rounded-xl p-4 text-center border border-amber-100">
                                    <p class="text-2xl font-extrabold text-amber-700">8</p>
                                    <p class="text-xs font-medium text-amber-500 mt-1">Classes</p>
                                </div>
                                <div class="bg-purple-50 rounded-xl p-4 text-center border border-purple-100">
                                    <p class="text-2xl font-extrabold text-purple-700">48</p>
                                    <p class="text-xs font-medium text-purple-500 mt-1">Exams</p>
                                </div>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-sm font-semibold text-gray-700">Today's Attendance</span>
                                    <span class="text-sm font-bold text-indigo-600">75%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-2.5 rounded-full" style="width: 75%"></div>
                                </div>
                                <div class="flex gap-4 mt-3 text-xs text-gray-500">
                                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span> 22 Present</span>
                                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-amber-500"></span> 3 Late</span>
                                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-500"></span> 5 Absent</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section id="features" class="py-20 lg:py-28 bg-gray-50/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-sm font-bold text-indigo-600 uppercase tracking-wider">Features</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold mt-3 mb-4">Everything You Need</h2>
                <p class="text-gray-500 text-lg">A complete system designed for schools, colleges, and training centers.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @php
                    $features = [
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>', 'title' => 'Attendance Tracking', 'desc' => 'Mark attendance for entire classes in seconds. Track daily, weekly, and monthly reports with CSV export.', 'color' => 'indigo'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>', 'title' => 'Grade Management', 'desc' => 'Create exams, enter marks in bulk, calculate percentages, and generate printable report cards.', 'color' => 'emerald'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>', 'title' => 'Timetable Builder', 'desc' => 'Build weekly schedules with a visual timetable grid. Automatic conflict detection prevents double-booking.', 'color' => 'violet'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>', 'title' => 'Student Management', 'desc' => 'Manage student profiles, enroll in classes, track academic history, and maintain complete records.', 'color' => 'blue'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>', 'title' => 'Global Search', 'desc' => 'Instantly search across students, teachers, and classes from anywhere in the system.', 'color' => 'rose'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>', 'title' => 'Dashboards & Reports', 'desc' => 'Role-specific dashboards with live stats. Admins, teachers, and students each see what matters.', 'color' => 'amber'],
                    ];
                @endphp
                @foreach($features as $f)
                    <div class="group bg-white rounded-2xl p-7 border border-gray-100 hover:border-gray-200 hover:shadow-xl hover:shadow-gray-100 transition-all duration-300">
                        <div class="w-12 h-12 bg-{{ $f['color'] }}-50 group-hover:bg-{{ $f['color'] }}-100 rounded-xl flex items-center justify-center mb-5 transition-colors">
                            <svg class="w-6 h-6 text-{{ $f['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $f['icon'] !!}</svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $f['title'] }}</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Modules --}}
    <section id="modules" class="py-20 lg:py-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-sm font-bold text-indigo-600 uppercase tracking-wider">Modules</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold mt-3 mb-4">8 Powerful Modules</h2>
                <p class="text-gray-500 text-lg">Each built for a specific purpose. Together they form a complete school management system.</p>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @php
                    $modules = [
                        ['icon' => '👤', 'name' => 'Students', 'desc' => 'CRUD, enrollment, profiles', 'bg' => 'bg-blue-50', 'border' => 'border-blue-100', 'iconBg' => 'bg-blue-100'],
                        ['icon' => '👨‍🏫', 'name' => 'Teachers', 'desc' => 'Profiles, subject assignment', 'bg' => 'bg-emerald-50', 'border' => 'border-emerald-100', 'iconBg' => 'bg-emerald-100'],
                        ['icon' => '🏫', 'name' => 'Classes', 'desc' => 'Sections, capacity, teachers', 'bg' => 'bg-amber-50', 'border' => 'border-amber-100', 'iconBg' => 'bg-amber-100'],
                        ['icon' => '📚', 'name' => 'Subjects', 'desc' => 'Per class, teacher mapping', 'bg' => 'bg-violet-50', 'border' => 'border-violet-100', 'iconBg' => 'bg-violet-100'],
                        ['icon' => '📋', 'name' => 'Attendance', 'desc' => 'Mark, history, reports, CSV', 'bg' => 'bg-rose-50', 'border' => 'border-rose-100', 'iconBg' => 'bg-rose-100'],
                        ['icon' => '📊', 'name' => 'Grades', 'desc' => 'Exams, marks, report cards', 'bg' => 'bg-indigo-50', 'border' => 'border-indigo-100', 'iconBg' => 'bg-indigo-100'],
                        ['icon' => '📅', 'name' => 'Schedule', 'desc' => 'Timetable, conflict detect', 'bg' => 'bg-pink-50', 'border' => 'border-pink-100', 'iconBg' => 'bg-pink-100'],
                        ['icon' => '🔍', 'name' => 'Search', 'desc' => 'Global search all modules', 'bg' => 'bg-gray-50', 'border' => 'border-gray-200', 'iconBg' => 'bg-gray-100'],
                    ];
                @endphp
                @foreach($modules as $m)
                    <div class="{{ $m['bg'] }} {{ $m['border'] }} border rounded-2xl p-5 hover:shadow-lg transition-shadow duration-300 cursor-default">
                        <div class="w-11 h-11 {{ $m['iconBg'] }} rounded-xl flex items-center justify-center text-xl mb-3">{{ $m['icon'] }}</div>
                        <h4 class="font-bold text-gray-900 mb-1">{{ $m['name'] }}</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">{{ $m['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section id="steps" class="py-20 lg:py-28 bg-gray-50/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-sm font-bold text-indigo-600 uppercase tracking-wider">How It Works</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold mt-3 mb-4">3 Simple Steps</h2>
                <p class="text-gray-500 text-lg">Get started in minutes — no complex setup required.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8 relative">
                {{-- Connector Line --}}
                <div class="hidden md:block absolute top-14 left-1/6 right-1/6 h-px bg-gray-200"></div>

                @php
                    $steps = [
                        ['num' => '1', 'title' => 'Set Up', 'desc' => 'Create classes, assign subjects and teachers. Build the foundation of your school structure.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>'],
                        ['num' => '2', 'title' => 'Enroll & Manage', 'desc' => 'Add students, enroll them in classes, build timetables, and start marking attendance daily.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>'],
                        ['num' => '3', 'title' => 'Track & Report', 'desc' => 'Enter exam marks, generate report cards, view attendance reports, and monitor progress.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>'],
                    ];
                @endphp
                @foreach($steps as $s)
                    <div class="text-center relative">
                        <div class="w-14 h-14 bg-gray-900 text-white rounded-2xl flex items-center justify-center text-xl font-black mx-auto mb-6 relative z-10 shadow-lg shadow-gray-900/20">{{ $s['num'] }}</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $s['title'] }}</h3>
                        <p class="text-gray-500 text-sm leading-relaxed max-w-xs mx-auto">{{ $s['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-20 lg:py-28">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <div class="bg-gray-900 rounded-3xl p-10 sm:p-14 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-purple-500 rounded-full blur-3xl"></div>
                </div>
                <div class="relative z-10">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">Ready to Get Started?</h2>
                    <p class="text-gray-400 text-lg mb-8 max-w-lg mx-auto">Join TCMS and start managing your school smarter today. It's free.</p>
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-white text-gray-900 hover:bg-gray-100 px-10 py-4 rounded-2xl font-bold text-lg transition shadow-xl inline-block">
                            Go to Dashboard →
                        </a>
                    @else
                        <div class="flex justify-center gap-4">
                            <a href="{{ route('register') }}" class="bg-white text-gray-900 hover:bg-gray-100 px-10 py-4 rounded-2xl font-bold text-lg transition shadow-xl">
                                Get Started Free →
                            </a>
                            <a href="{{ route('login') }}" class="border-2 border-white/20 text-white hover:bg-white/10 px-10 py-4 rounded-2xl font-bold text-lg transition">
                                Sign In
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-gray-100 py-10">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="flex items-center justify-center gap-2 mb-3">
                <div class="w-7 h-7 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <span class="text-white text-[10px] font-extrabold">T</span>
                </div>
                <span class="text-sm font-bold text-gray-900">TCMS</span>
            </div>
            <p class="text-sm text-gray-400">Class Management System · Built with Laravel & Tailwind CSS</p>
        </div>
    </footer>

</body>
</html>

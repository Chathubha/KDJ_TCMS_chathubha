<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'TCMS') }} - Class Management System</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero-gradient { background: linear-gradient(135deg, #1e1b4b 0%, #312e81 30%, #4338ca 60%, #6366f1 100%); }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        .float-animation { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%,100%{ transform: translateY(0); } 50%{ transform: translateY(-10px); } }
        .gradient-text { background: linear-gradient(135deg, #6366f1, #8b5cf6, #a855f7); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
</head>
<body class="font-sans antialiased bg-white">

    {{-- Navbar --}}
    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center">
                        <span class="text-white text-lg font-bold">🎓</span>
                    </div>
                    <span class="text-xl font-bold text-gray-900">TCMS</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-indigo-600 font-medium transition">Features</a>
                    <a href="#modules" class="text-gray-600 hover:text-indigo-600 font-medium transition">Modules</a>
                    <a href="#how-it-works" class="text-gray-600 hover:text-indigo-600 font-medium transition">How It Works</a>
                </div>
                <div class="flex items-center space-x-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg font-medium transition shadow-lg shadow-indigo-200">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 font-medium transition">Log in</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg font-medium transition shadow-lg shadow-indigo-200">Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="hero-gradient min-h-screen flex items-center pt-16 overflow-hidden relative">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
            <div class="absolute top-1/2 left-1/2 w-80 h-80 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-block bg-white/10 backdrop-blur-sm text-white/90 text-sm font-medium px-4 py-2 rounded-full mb-6 border border-white/20">
                        🚀 Modern Class Management
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
                        Manage Your School
                        <span class="block text-indigo-200">Smarter, Not Harder</span>
                    </h1>
                    <p class="text-lg text-indigo-100 mb-8 leading-relaxed max-w-lg">
                        A complete class management system for schools and colleges. Track attendance, manage grades, build timetables, and monitor student performance — all in one place.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="bg-white text-indigo-700 hover:bg-gray-100 px-8 py-3 rounded-xl font-bold text-lg transition shadow-xl">
                                Go to Dashboard →
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="bg-white text-indigo-700 hover:bg-gray-100 px-8 py-3 rounded-xl font-bold text-lg transition shadow-xl">
                                Get Started Free →
                            </a>
                            <a href="{{ route('login') }}" class="border-2 border-white/30 text-white hover:bg-white/10 px-8 py-3 rounded-xl font-bold text-lg transition">
                                Log In
                            </a>
                        @endauth
                    </div>
                    <div class="flex items-center space-x-6 mt-10 text-indigo-200 text-sm">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span>30 Students</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span>10 Teachers</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span>8 Classes</span>
                        </div>
                    </div>
                </div>
                <div class="hidden lg:block float-animation">
                    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20 shadow-2xl">
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-3 h-3 rounded-full bg-red-400"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                            <div class="w-3 h-3 rounded-full bg-green-400"></div>
                            <span class="ml-2 text-white/60 text-sm">Dashboard Preview</span>
                        </div>
                        <div class="grid grid-cols-3 gap-3 mb-4">
                            <div class="bg-blue-500/30 rounded-lg p-3 text-center">
                                <div class="text-2xl font-bold text-white">30</div>
                                <div class="text-xs text-blue-200">Students</div>
                            </div>
                            <div class="bg-green-500/30 rounded-lg p-3 text-center">
                                <div class="text-2xl font-bold text-white">10</div>
                                <div class="text-xs text-green-200">Teachers</div>
                            </div>
                            <div class="bg-purple-500/30 rounded-lg p-3 text-center">
                                <div class="text-2xl font-bold text-white">8</div>
                                <div class="text-xs text-purple-200">Classes</div>
                            </div>
                        </div>
                        <div class="bg-white/10 rounded-lg p-3">
                            <div class="text-xs text-white/60 mb-2">Today's Attendance</div>
                            <div class="w-full bg-white/20 rounded-full h-2">
                                <div class="bg-green-400 h-2 rounded-full" style="width: 75%"></div>
                            </div>
                            <div class="text-right text-xs text-green-300 mt-1">75%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Everything You Need</h2>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto">A complete system designed for schools, colleges, and training centers. Simple, powerful, and easy to use.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 card-hover transition-all duration-300">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                        <span class="text-2xl">📋</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Attendance Tracking</h3>
                    <p class="text-gray-500 leading-relaxed">Mark attendance for entire classes in one click. Track daily, weekly, and monthly reports with export to CSV.</p>
                </div>
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 card-hover transition-all duration-300">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                        <span class="text-2xl">📊</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Grade Management</h3>
                    <p class="text-gray-500 leading-relaxed">Create exams, enter marks in bulk, calculate percentages, and generate printable report cards for every student.</p>
                </div>
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 card-hover transition-all duration-300">
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                        <span class="text-2xl">📅</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Timetable Builder</h3>
                    <p class="text-gray-500 leading-relaxed">Build weekly schedules with visual timetable grid. Automatic conflict detection prevents teacher double-booking.</p>
                </div>
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 card-hover transition-all duration-300">
                    <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center mb-6">
                        <span class="text-2xl">👥</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Student Management</h3>
                    <p class="text-gray-500 leading-relaxed">Manage student profiles, enroll in classes, track academic history, and maintain complete records.</p>
                </div>
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 card-hover transition-all duration-300">
                    <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center mb-6">
                        <span class="text-2xl">🔍</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Global Search</h3>
                    <p class="text-gray-500 leading-relaxed">Instantly search across students, teachers, and classes from anywhere in the system with the top search bar.</p>
                </div>
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 card-hover transition-all duration-300">
                    <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center mb-6">
                        <span class="text-2xl">📈</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Dashboards & Reports</h3>
                    <p class="text-gray-500 leading-relaxed">Role-specific dashboards with live stats. Admins see everything, teachers see their classes, students see their progress.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Modules --}}
    <section id="modules" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">8 Powerful Modules</h2>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto">Each module is built for a specific purpose. Together they form a complete school management system.</p>
            </div>
            <div class="grid md:grid-cols-4 gap-4">
                @php
                    $modules = [
                        ['icon' => '👤', 'name' => 'Students', 'desc' => 'CRUD, enrollment, profiles', 'color' => 'blue'],
                        ['icon' => '👨‍🏫', 'name' => 'Teachers', 'desc' => 'Profiles, subject assignment', 'color' => 'green'],
                        ['icon' => '🏫', 'name' => 'Classes', 'desc' => 'Sections, capacity, teachers', 'color' => 'yellow'],
                        ['icon' => '📚', 'name' => 'Subjects', 'desc' => 'Per class, teacher mapping', 'color' => 'purple'],
                        ['icon' => '📋', 'name' => 'Attendance', 'desc' => 'Mark, history, reports, CSV', 'color' => 'red'],
                        ['icon' => '📊', 'name' => 'Grades', 'desc' => 'Exams, marks, report cards', 'color' => 'indigo'],
                        ['icon' => '📅', 'name' => 'Schedule', 'desc' => 'Timetable, conflict detect', 'color' => 'pink'],
                        ['icon' => '🔍', 'name' => 'Search', 'desc' => 'Global search all modules', 'color' => 'gray'],
                    ];
                @endphp
                @foreach($modules as $m)
                    <div class="bg-{{ $m['color'] }}-50 rounded-xl p-5 border border-{{ $m['color'] }}-100 hover:shadow-md transition">
                        <div class="text-3xl mb-3">{{ $m['icon'] }}</div>
                        <h4 class="font-bold text-gray-900 mb-1">{{ $m['name'] }}</h4>
                        <p class="text-sm text-gray-500">{{ $m['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section id="how-it-works" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">How It Works</h2>
                <p class="text-lg text-gray-500">3 simple steps to get started</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-600 text-white rounded-2xl flex items-center justify-center text-2xl font-bold mx-auto mb-6">1</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Set Up</h3>
                    <p class="text-gray-500">Create classes, assign subjects and teachers. Build the foundation of your school structure.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-600 text-white rounded-2xl flex items-center justify-center text-2xl font-bold mx-auto mb-6">2</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Enroll & Manage</h3>
                    <p class="text-gray-500">Add students, enroll them in classes, build timetables, and start marking attendance daily.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-600 text-white rounded-2xl flex items-center justify-center text-2xl font-bold mx-auto mb-6">3</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Track & Report</h3>
                    <p class="text-gray-500">Enter exam marks, generate report cards, view attendance reports, and monitor student progress.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-20 hero-gradient">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-6">Ready to Get Started?</h2>
            <p class="text-lg text-indigo-200 mb-8">Join TCMS and start managing your school smarter today.</p>
            @auth
                <a href="{{ route('dashboard') }}" class="bg-white text-indigo-700 hover:bg-gray-100 px-10 py-4 rounded-xl font-bold text-lg transition shadow-xl inline-block">
                    Go to Dashboard →
                </a>
            @else
                <div class="flex justify-center gap-4">
                    <a href="{{ route('register') }}" class="bg-white text-indigo-700 hover:bg-gray-100 px-10 py-4 rounded-xl font-bold text-lg transition shadow-xl">
                        Get Started Free →
                    </a>
                    <a href="{{ route('login') }}" class="border-2 border-white/30 text-white hover:bg-white/10 px-10 py-4 rounded-xl font-bold text-lg transition">
                        Log In
                    </a>
                </div>
            @endauth
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="flex items-center justify-center space-x-2 mb-4">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                    <span class="text-white text-sm font-bold">🎓</span>
                </div>
                <span class="text-white font-bold">TCMS</span>
            </div>
            <p class="text-sm">Class Management System — Built with Laravel + Tailwind CSS</p>
            <p class="text-xs text-gray-500 mt-2">{{ date('Y') }} All rights reserved.</p>
        </div>
    </footer>

</body>
</html>

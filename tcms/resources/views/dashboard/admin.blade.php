<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Admin Dashboard</h2>
                <p class="text-sm text-gray-500 mt-1">Welcome back, {{ Auth::user()->name }}. Here's what's happening today.</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-gray-500">{{ now()->format('l') }}</p>
                <p class="text-lg font-bold text-gray-900">{{ now()->format('M d, Y') }}</p>
            </div>
        </div>
    </x-slot>

    @php
        $totalStudents = \App\Models\Student::count();
        $totalTeachers = \App\Models\Teacher::count();
        $totalClasses = \App\Models\Classroom::count();
        $totalSubjects = \App\Models\Subject::count();
        $totalExams = \App\Models\Exam::count();
        $todayPresent = \App\Models\Attendance::where('date', today())->where('status', 'present')->count();
        $todayAbsent = \App\Models\Attendance::where('date', today())->where('status', 'absent')->count();
        $todayLate = \App\Models\Attendance::where('date', today())->where('status', 'late')->count();
        $todayTotal = $todayPresent + $todayAbsent + $todayLate;
        $todayPercentage = $todayTotal > 0 ? round($todayPresent / $todayTotal * 100, 1) : 0;
        $recentStudents = \App\Models\Student::with('user', 'classrooms')->latest()->take(5)->get();
        $recentTeachers = \App\Models\Teacher::with('user')->latest()->take(5)->get();
        $upcomingExams = \App\Models\Exam::with('subject', 'classroom')->where('date', '>=', today())->orderBy('date')->take(5)->get();
    @endphp

    <div class="space-y-6">

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Students</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalStudents }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-blue-600 font-semibold">{{ $totalClasses }} classes</span>
                    <span class="text-gray-400 mx-1">·</span>
                    <a href="{{ route('students.index') }}" class="text-gray-500 hover:text-blue-600">View all →</a>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Teachers</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalTeachers }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-green-600 font-semibold">{{ $totalSubjects }} subjects</span>
                    <span class="text-gray-400 mx-1">·</span>
                    <a href="{{ route('teachers.index') }}" class="text-gray-500 hover:text-green-600">View all →</a>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Classes</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalClasses }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <a href="{{ route('classrooms.index') }}" class="text-gray-500 hover:text-amber-600">Manage classes →</a>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Exams</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalExams }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <a href="{{ route('grades.index') }}" class="text-gray-500 hover:text-purple-600">Manage exams →</a>
                </div>
            </div>
        </div>

        {{-- Attendance + Recent Students --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            {{-- Today's Attendance --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Today's Attendance</h3>
                        <p class="text-sm text-gray-500">For all classes combined</p>
                    </div>
                    <a href="{{ route('attendance.report') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">View Report →</a>
                </div>

                @if($todayTotal > 0)
                    {{-- Progress Ring --}}
                    <div class="flex items-center gap-8 mb-6">
                        <div class="relative w-28 h-28 flex-shrink-0">
                            <svg class="w-28 h-28 -rotate-90" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="40" stroke-width="10" fill="none" class="stroke-gray-100"/>
                                <circle cx="50" cy="50" r="40" stroke-width="10" fill="none"
                                    class="stroke-indigo-500" stroke-linecap="round"
                                    stroke-dasharray="{{ 2 * 3.14159 * 40 }}"
                                    stroke-dashoffset="{{ 2 * 3.14159 * 40 * (1 - $todayPercentage / 100) }}"/>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-2xl font-extrabold text-gray-900">{{ $todayPercentage }}%</span>
                            </div>
                        </div>
                        <div class="flex-1 space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                    <span class="text-sm text-gray-600">Present</span>
                                </div>
                                <span class="text-sm font-bold text-gray-900">{{ $todayPresent }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                                    <span class="text-sm text-gray-600">Late</span>
                                </div>
                                <span class="text-sm font-bold text-gray-900">{{ $todayLate }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    <span class="text-sm text-gray-600">Absent</span>
                                </div>
                                <span class="text-sm font-bold text-gray-900">{{ $todayAbsent }}</span>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-100 pt-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-gray-300"></div>
                                    <span class="text-sm font-semibold text-gray-700">Total</span>
                                </div>
                                <span class="text-sm font-bold text-gray-900">{{ $todayTotal }}</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('attendance.mark') }}" class="block w-full text-center bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-semibold py-2.5 rounded-xl transition">Mark Attendance →</a>
                @else
                    <div class="text-center py-10 bg-gray-50 rounded-xl">
                        <div class="text-4xl mb-3">📋</div>
                        <p class="text-gray-500 font-medium">No attendance recorded today</p>
                        <a href="{{ route('attendance.mark') }}" class="inline-block mt-3 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl font-semibold text-sm transition">Mark Attendance →</a>
                    </div>
                @endif
            </div>

            {{-- Recent Students --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Recent Students</h3>
                    <a href="{{ route('students.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">View All →</a>
                </div>
                <div class="space-y-4">
                    @forelse($recentStudents as $student)
                        <a href="{{ route('students.show', $student) }}" class="flex items-center gap-3 p-2 -mx-2 rounded-xl hover:bg-gray-50 transition">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $student->full_name }}</p>
                                <p class="text-xs text-gray-500">{{ $student->classrooms->first()?->name ?? '' }}-{{ $student->classrooms->first()?->section ?? 'Unassigned' }}</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    @empty
                        <p class="text-sm text-gray-400 text-center py-4">No students yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Quick Actions + Upcoming Exams --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            {{-- Quick Actions --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Quick Actions</h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('students.create') }}" class="group flex items-center gap-4 p-4 rounded-xl border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50 transition">
                        <div class="w-11 h-11 bg-blue-100 group-hover:bg-blue-200 rounded-xl flex items-center justify-center transition">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Add Student</p>
                            <p class="text-xs text-gray-500">New enrollment</p>
                        </div>
                    </a>
                    <a href="{{ route('teachers.create') }}" class="group flex items-center gap-4 p-4 rounded-xl border border-gray-100 hover:border-green-200 hover:bg-green-50 transition">
                        <div class="w-11 h-11 bg-green-100 group-hover:bg-green-200 rounded-xl flex items-center justify-center transition">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Add Teacher</p>
                            <p class="text-xs text-gray-500">New staff member</p>
                        </div>
                    </a>
                    <a href="{{ route('attendance.mark') }}" class="group flex items-center gap-4 p-4 rounded-xl border border-gray-100 hover:border-amber-200 hover:bg-amber-50 transition">
                        <div class="w-11 h-11 bg-amber-100 group-hover:bg-amber-200 rounded-xl flex items-center justify-center transition">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Mark Attendance</p>
                            <p class="text-xs text-gray-500">Daily tracking</p>
                        </div>
                    </a>
                    <a href="{{ route('grades.create') }}" class="group flex items-center gap-4 p-4 rounded-xl border border-gray-100 hover:border-purple-200 hover:bg-purple-50 transition">
                        <div class="w-11 h-11 bg-purple-100 group-hover:bg-purple-200 rounded-xl flex items-center justify-center transition">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Add Exam</p>
                            <p class="text-xs text-gray-500">Create new exam</p>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Upcoming Exams --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Upcoming Exams</h3>
                    <a href="{{ route('grades.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">View All →</a>
                </div>
                @if($upcomingExams->count() > 0)
                    <div class="space-y-3">
                        @foreach($upcomingExams as $exam)
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition">
                                <div class="w-11 h-11 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $exam->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $exam->subject->name ?? '-' }} · {{ $exam->classroom->name ?? '' }}-{{ $exam->classroom->section ?? '' }}</p>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-sm font-bold text-gray-900">{{ $exam->date?->format('M d') ?? '-' }}</p>
                                    <p class="text-xs text-gray-500">Max: {{ $exam->max_marks }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10 bg-gray-50 rounded-xl">
                        <div class="text-4xl mb-3">📝</div>
                        <p class="text-gray-500 font-medium">No upcoming exams</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Module Links --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6">All Modules</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <a href="{{ route('students.index') }}" class="group flex items-center gap-3 p-4 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50 transition">
                    <div class="w-10 h-10 bg-blue-100 group-hover:bg-blue-200 rounded-lg flex items-center justify-center transition">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 group-hover:text-blue-700">Students</span>
                </a>
                <a href="{{ route('teachers.index') }}" class="group flex items-center gap-3 p-4 rounded-xl border border-gray-100 hover:border-green-200 hover:bg-green-50 transition">
                    <div class="w-10 h-10 bg-green-100 group-hover:bg-green-200 rounded-lg flex items-center justify-center transition">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 group-hover:text-green-700">Teachers</span>
                </a>
                <a href="{{ route('classrooms.index') }}" class="group flex items-center gap-3 p-4 rounded-xl border border-gray-100 hover:border-amber-200 hover:bg-amber-50 transition">
                    <div class="w-10 h-10 bg-amber-100 group-hover:bg-amber-200 rounded-lg flex items-center justify-center transition">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 group-hover:text-amber-700">Classes</span>
                </a>
                <a href="{{ route('subjects.index') }}" class="group flex items-center gap-3 p-4 rounded-xl border border-gray-100 hover:border-purple-200 hover:bg-purple-50 transition">
                    <div class="w-10 h-10 bg-purple-100 group-hover:bg-purple-200 rounded-lg flex items-center justify-center transition">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 group-hover:text-purple-700">Subjects</span>
                </a>
                <a href="{{ route('attendance.index') }}" class="group flex items-center gap-3 p-4 rounded-xl border border-gray-100 hover:border-red-200 hover:bg-red-50 transition">
                    <div class="w-10 h-10 bg-red-100 group-hover:bg-red-200 rounded-lg flex items-center justify-center transition">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 group-hover:text-red-700">Attendance</span>
                </a>
                <a href="{{ route('grades.index') }}" class="group flex items-center gap-3 p-4 rounded-xl border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50 transition">
                    <div class="w-10 h-10 bg-indigo-100 group-hover:bg-indigo-200 rounded-lg flex items-center justify-center transition">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 group-hover:text-indigo-700">Grades</span>
                </a>
                <a href="{{ route('schedule.index') }}" class="group flex items-center gap-3 p-4 rounded-xl border border-gray-100 hover:border-pink-200 hover:bg-pink-50 transition">
                    <div class="w-10 h-10 bg-pink-100 group-hover:bg-pink-200 rounded-lg flex items-center justify-center transition">
                        <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 group-hover:text-pink-700">Schedule</span>
                </a>
                <a href="{{ route('search') }}" class="group flex items-center gap-3 p-4 rounded-xl border border-gray-100 hover:border-gray-300 hover:bg-gray-50 transition">
                    <div class="w-10 h-10 bg-gray-100 group-hover:bg-gray-200 rounded-lg flex items-center justify-center transition">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 group-hover:text-gray-900">Search</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

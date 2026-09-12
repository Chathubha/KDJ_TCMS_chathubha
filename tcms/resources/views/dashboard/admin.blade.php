<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Admin Dashboard</h2>
    </x-slot>

    @php
        $totalStudents = \App\Models\Student::count();
        $totalTeachers = \App\Models\Teacher::count();
        $totalClasses = \App\Models\Classroom::count();
        $totalSubjects = \App\Models\Subject::count();
        $todayPresent = \App\Models\Attendance::where('date', today())->where('status', 'present')->count();
        $todayAbsent = \App\Models\Attendance::where('date', today())->where('status', 'absent')->count();
        $todayTotal = $todayPresent + $todayAbsent;
        $todayPercentage = $todayTotal > 0 ? round($todayPresent / $todayTotal * 100, 1) : 0;
        $recentStudents = \App\Models\Student::with('user')->latest()->take(5)->get();
    @endphp

    <div class="space-y-6">
        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-500 rounded-full text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Students</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalStudents }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-500 rounded-full text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Teachers</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalTeachers }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-500 rounded-full text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Classes</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalClasses }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-500 rounded-full text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Subjects</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalSubjects }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Today's Attendance --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Today's Attendance</h3>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-500">Attendance Rate</span>
                    <span class="text-sm font-bold {{ $todayPercentage >= 75 ? 'text-green-600' : 'text-red-600' }}">{{ $todayPercentage }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3 mb-4">
                    <div class="bg-green-500 h-3 rounded-full" style="width: {{ $todayPercentage }}%"></div>
                </div>
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <p class="text-2xl font-bold text-green-600">{{ $todayPresent }}</p>
                        <p class="text-xs text-gray-500">Present</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-red-600">{{ $todayAbsent }}</p>
                        <p class="text-xs text-gray-500">Absent</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-600">{{ $todayTotal }}</p>
                        <p class="text-xs text-gray-500">Total</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('attendance.report') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View Full Report →</a>
                </div>
            </div>

            {{-- Recent Students --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Students</h3>
                <div class="space-y-3">
                    @forelse($recentStudents as $student)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-sm font-bold text-blue-600">
                                    {{ substr($student->first_name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $student->full_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $student->classrooms->first()?->name ?? '' }}-{{ $student->classrooms->first()?->section ?? '' }}</p>
                                </div>
                            </div>
                            <a href="{{ route('students.show', $student) }}" class="text-blue-600 hover:text-blue-800 text-sm">View</a>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">No students yet.</p>
                    @endforelse
                </div>
                <div class="mt-4">
                    <a href="{{ route('students.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All Students →</a>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('students.create') }}" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
                    <div class="text-2xl mb-2">👤</div>
                    <div class="font-medium text-gray-900 text-sm">Add Student</div>
                </a>
                <a href="{{ route('teachers.create') }}" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
                    <div class="text-2xl mb-2">👨‍🏫</div>
                    <div class="font-medium text-gray-900 text-sm">Add Teacher</div>
                </a>
                <a href="{{ route('attendance.mark') }}" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
                    <div class="text-2xl mb-2">📋</div>
                    <div class="font-medium text-gray-900 text-sm">Mark Attendance</div>
                </a>
                <a href="{{ route('grades.create') }}" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
                    <div class="text-2xl mb-2">📝</div>
                    <div class="font-medium text-gray-900 text-sm">Add Exam</div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

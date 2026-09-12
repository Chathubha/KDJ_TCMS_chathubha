<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Teacher Dashboard</h2>
                <p class="text-sm text-gray-500 mt-1">Welcome back, {{ Auth::user()->name }}.</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-gray-500">{{ now()->format('l') }}</p>
                <p class="text-lg font-bold text-gray-900">{{ now()->format('M d, Y') }}</p>
            </div>
        </div>
    </x-slot>

    @php
        $teacher = auth()->user()->teacher;
        $assignedSubjects = $teacher?->subjects ?? collect();
        $scheduleToday = \App\Models\Schedule::where('teacher_id', $teacher?->id)
            ->where('day', strtolower(now()->format('l')))
            ->with(['classroom', 'subject', 'period'])
            ->orderBy('period_id')
            ->get();
        $totalClasses = $teacher ? \App\Models\Schedule::where('teacher_id', $teacher->id)->distinct('classroom_id')->count('classroom_id') : 0;
        $totalPeriodsToday = $scheduleToday->count();
        $nextClass = $scheduleToday->first();
    @endphp

    <div class="space-y-6">

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Assigned Subjects</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $assignedSubjects->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                </div>
                <div class="mt-3 flex flex-wrap gap-1">
                    @foreach($assignedSubjects->take(4) as $subject)
                        <span class="bg-indigo-50 text-indigo-700 text-xs font-medium px-2.5 py-1 rounded-full">{{ $subject->name }}</span>
                    @endforeach
                    @if($assignedSubjects->count() > 4)
                        <span class="bg-gray-100 text-gray-600 text-xs font-medium px-2.5 py-1 rounded-full">+{{ $assignedSubjects->count() - 4 }}</span>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Classes Assigned</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalClasses }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Today's Classes</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalPeriodsToday }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Today's Schedule + Quick Actions --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            {{-- Schedule --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Today's Schedule</h3>
                        <p class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</p>
                    </div>
                    <a href="{{ route('schedule.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">Full Timetable →</a>
                </div>

                @if($scheduleToday->count() > 0)
                    <div class="space-y-3">
                        @foreach($scheduleToday as $index => $s)
                            <div class="flex items-center gap-4 p-4 rounded-xl {{ $index === 0 ? 'bg-indigo-50 border border-indigo-200' : 'bg-gray-50 border border-gray-100' }} hover:shadow-sm transition">
                                <div class="w-12 h-12 {{ $index === 0 ? 'bg-indigo-600' : 'bg-white' }} rounded-xl flex flex-col items-center justify-center flex-shrink-0 {{ $index === 0 ? 'text-white' : 'border border-gray-200' }}">
                                    <span class="text-xs font-bold leading-none">{{ $s->period?->start_time?->format('H:i') ?? '' }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-bold text-gray-900">{{ $s->subject->name ?? '-' }}</p>
                                        @if($index === 0)
                                            <span class="bg-indigo-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">NOW</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $s->period->name ?? '' }} · {{ $s->classroom->name ?? '' }}-{{ $s->classroom->section ?? '' }}</p>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-xs text-gray-400">{{ $s->period?->start_time?->format('g:i A') ?? '' }} - {{ $s->period?->end_time?->format('g:i A') ?? '' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-gray-50 rounded-xl">
                        <div class="text-4xl mb-3">📅</div>
                        <p class="text-gray-500 font-medium">No classes scheduled for today</p>
                        <p class="text-sm text-gray-400 mt-1">Enjoy your day off!</p>
                    </div>
                @endif
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('attendance.mark') }}" class="group flex items-center gap-3 p-4 rounded-xl border border-gray-100 hover:border-amber-200 hover:bg-amber-50 transition">
                        <div class="w-10 h-10 bg-amber-100 group-hover:bg-amber-200 rounded-xl flex items-center justify-center transition">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Mark Attendance</p>
                            <p class="text-xs text-gray-500">For your classes</p>
                        </div>
                    </a>
                    <a href="{{ route('schedule.index') }}" class="group flex items-center gap-3 p-4 rounded-xl border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50 transition">
                        <div class="w-10 h-10 bg-indigo-100 group-hover:bg-indigo-200 rounded-xl flex items-center justify-center transition">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">View Timetable</p>
                            <p class="text-xs text-gray-500">Weekly schedule</p>
                        </div>
                    </a>
                    <a href="{{ route('students.index') }}" class="group flex items-center gap-3 p-4 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50 transition">
                        <div class="w-10 h-10 bg-blue-100 group-hover:bg-blue-200 rounded-xl flex items-center justify-center transition">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">View Students</p>
                            <p class="text-xs text-gray-500">All enrolled</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

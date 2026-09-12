<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Student Dashboard</h2>
                <p class="text-sm text-gray-500 mt-1">Welcome back, {{ Auth::user()->name }}.</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-gray-500">{{ now()->format('l') }}</p>
                <p class="text-lg font-bold text-gray-900">{{ now()->format('M d, Y') }}</p>
            </div>
        </div>
    </x-slot>

    @php
        $student = auth()->user()->student;
        $classroom = $student?->classrooms->first();
        $totalAttendance = $student ? \App\Models\Attendance::where('student_id', $student->id)->count() : 0;
        $presentCount = $student ? \App\Models\Attendance::where('student_id', $student->id)->where('status', 'present')->count() : 0;
        $lateCount = $student ? \App\Models\Attendance::where('student_id', $student->id)->where('status', 'late')->count() : 0;
        $absentCount = $student ? \App\Models\Attendance::where('student_id', $student->id)->where('status', 'absent')->count() : 0;
        $attendancePercentage = $totalAttendance > 0 ? round(($presentCount + $lateCount) / $totalAttendance * 100, 1) : 0;
        $grades = $student ? \App\Models\Grade::where('student_id', $student->id)->with('exam')->get() : collect();
        $totalMarks = $grades->sum('marks_obtained');
        $totalMax = $grades->sum('exam.max_marks');
        $gradePercentage = $totalMax > 0 ? round($totalMarks / $totalMax * 100, 1) : 0;
        $scheduleToday = null;
        if ($classroom) {
            $scheduleToday = \App\Models\Schedule::where('classroom_id', $classroom->id)
                ->where('day', strtolower(now()->format('l')))
                ->with(['subject', 'teacher', 'period'])
                ->orderBy('period_id')
                ->get();
        }
    @endphp

    <div class="space-y-6">

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            {{-- Class --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">My Class</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $classroom?->name ?? '-' }}-{{ $classroom?->section ?? '' }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                </div>
                <div class="mt-3 text-xs text-gray-500">{{ $classroom?->academic_year ?? '-' }}</div>
            </div>

            {{-- Attendance --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Attendance</p>
                        <p class="text-3xl font-extrabold {{ $attendancePercentage >= 75 ? 'text-green-600' : $attendancePercentage >= 50 ? 'text-amber-600' : 'text-red-600' }} mt-1">{{ $attendancePercentage }}%</p>
                    </div>
                    <div class="w-12 h-12 {{ $attendancePercentage >= 75 ? 'bg-green-50' : $attendancePercentage >= 50 ? 'bg-amber-50' : 'bg-red-50' }} rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 {{ $attendancePercentage >= 75 ? 'text-green-600' : $attendancePercentage >= 50 ? 'text-amber-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                </div>
                <div class="mt-3 flex gap-3 text-xs">
                    <span class="text-green-600">{{ $presentCount }} present</span>
                    <span class="text-amber-600">{{ $lateCount }} late</span>
                    <span class="text-red-600">{{ $absentCount }} absent</span>
                </div>
            </div>

            {{-- Grades --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Grade Average</p>
                        <p class="text-3xl font-extrabold {{ $gradePercentage >= 50 ? 'text-indigo-600' : 'text-red-600' }} mt-1">{{ $gradePercentage }}%</p>
                    </div>
                    <div class="w-12 h-12 {{ $gradePercentage >= 50 ? 'bg-indigo-50' : 'bg-red-50' }} rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 {{ $gradePercentage >= 50 ? 'text-indigo-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                </div>
                <div class="mt-3 text-xs text-gray-500">{{ $totalMarks }} / {{ $totalMax }} marks total</div>
            </div>
        </div>

        {{-- Schedule + Grades --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

            {{-- Today's Schedule --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Today's Classes</h3>
                        <p class="text-sm text-gray-500">{{ now()->format('l') }}</p>
                    </div>
                    <a href="{{ route('schedule.index', ['classroom_id' => $classroom?->id]) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">View Timetable →</a>
                </div>

                @if($scheduleToday && $scheduleToday->count() > 0)
                    <div class="space-y-2">
                        @foreach($scheduleToday as $s)
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition">
                                <div class="w-10 h-10 bg-white border border-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <span class="text-xs font-bold text-gray-600">{{ $s->period?->start_time?->format('H:i') ?? '' }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900">{{ $s->subject->name ?? '-' }}</p>
                                    <p class="text-xs text-gray-500">{{ $s->teacher->full_name ?? '-' }}</p>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-xs font-medium text-gray-500">{{ $s->period?->name ?? '' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10 bg-gray-50 rounded-xl">
                        <div class="text-3xl mb-2">📅</div>
                        <p class="text-gray-500 font-medium text-sm">No classes today</p>
                    </div>
                @endif
            </div>

            {{-- Recent Grades --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Recent Grades</h3>
                    @if($classroom)
                        <a href="{{ route('grades.report-card', $student?->id) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">Report Card →</a>
                    @endif
                </div>

                @if($grades->count() > 0)
                    <div class="space-y-2">
                        @foreach($grades->take(6) as $grade)
                            @php $pct = $grade->exam->max_marks > 0 ? round(($grade->marks_obtained ?? 0) / $grade->exam->max_marks * 100, 1) : 0; @endphp
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition">
                                <div class="w-10 h-10 {{ $pct >= 50 ? 'bg-green-100' : 'bg-red-100' }} rounded-lg flex items-center justify-center flex-shrink-0">
                                    <span class="text-xs font-bold {{ $pct >= 50 ? 'text-green-700' : 'text-red-700' }}">{{ $pct }}%</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $grade->exam->name ?? '-' }}</p>
                                    <p class="text-xs text-gray-500">{{ $grade->marks_obtained ?? 0 }} / {{ $grade->exam->max_marks ?? 0 }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10 bg-gray-50 rounded-xl">
                        <div class="text-3xl mb-2">📝</div>
                        <p class="text-gray-500 font-medium text-sm">No grades yet</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- My Info Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6">My Information</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Name</p>
                    <p class="text-sm font-semibold text-gray-900 mt-1">{{ $student?->full_name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Email</p>
                    <p class="text-sm font-semibold text-gray-900 mt-1">{{ auth()->user()->email }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</p>
                    <p class="text-sm font-semibold text-gray-900 mt-1">{{ $student?->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</p>
                    <p class="text-sm font-semibold text-gray-900 mt-1 capitalize">{{ $student?->gender ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Student Dashboard</h2>
    </x-slot>

    @php
        $student = auth()->user()->student;
        $classroom = $student?->classrooms->first();
        $totalAttendance = $student ? \App\Models\Attendance::where('student_id', $student->id)->count() : 0;
        $presentCount = $student ? \App\Models\Attendance::where('student_id', $student->id)->where('status', 'present')->count() : 0;
        $lateCount = $student ? \App\Models\Attendance::where('student_id', $student->id)->where('status', 'late')->count() : 0;
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
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm text-gray-500">My Class</p>
                <p class="text-2xl font-bold text-gray-900">{{ $classroom?->name ?? '-' }}-{{ $classroom?->section ?? '' }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm text-gray-500">Attendance</p>
                <p class="text-2xl font-bold {{ $attendancePercentage >= 75 ? 'text-green-600' : 'text-red-600' }}">{{ $attendancePercentage }}%</p>
                <p class="text-xs text-gray-400">{{ $presentCount + $lateCount }}/{{ $totalAttendance }} days</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm text-gray-500">Grade Average</p>
                <p class="text-2xl font-bold {{ $gradePercentage >= 50 ? 'text-green-600' : 'text-red-600' }}">{{ $gradePercentage }}%</p>
                <p class="text-xs text-gray-400">{{ $totalMarks }}/{{ $totalMax }} marks</p>
            </div>
        </div>

        @if($scheduleToday && $scheduleToday->count() > 0)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold">Today's Schedule ({{ now()->format('l') }})</h3>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Period</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teacher</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($scheduleToday as $s)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium">{{ $s->period->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $s->period->start_time }} - {{ $s->period->end_time }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $s->subject->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $s->teacher->full_name ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @if($grades->count() > 0)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold">Recent Grades</h3>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Exam</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Marks</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Max</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">%</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($grades->take(10) as $grade)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium">{{ $grade->exam->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-center text-sm">{{ $grade->marks_obtained ?? '-' }}</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-500">{{ $grade->exam->max_marks ?? '-' }}</td>
                                @php $pct = $grade->exam->max_marks > 0 ? round(($grade->marks_obtained ?? 0) / $grade->exam->max_marks * 100, 1) : 0; @endphp
                                <td class="px-6 py-4 text-center text-sm font-bold {{ $pct >= 50 ? 'text-green-600' : 'text-red-600' }}">{{ $pct }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Teacher Dashboard</h2>
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
    @endphp

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm text-gray-500">Assigned Subjects</p>
                <p class="text-3xl font-bold text-gray-900">{{ $assignedSubjects->count() }}</p>
                <div class="mt-2 flex flex-wrap gap-1">
                    @foreach($assignedSubjects->take(3) as $subject)
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">{{ $subject->name }}</span>
                    @endforeach
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm text-gray-500">Classes Assigned</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalClasses }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm text-gray-500">Today's Periods</p>
                <p class="text-3xl font-bold text-gray-900">{{ $scheduleToday->count() }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold">Today's Schedule ({{ now()->format('l') }})</h3>
            </div>
            @if($scheduleToday->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Period</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($scheduleToday as $s)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium">{{ $s->period->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $s->period->start_time }} - {{ $s->period->end_time }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $s->subject->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $s->classroom->name ?? '-' }}-{{ $s->classroom->section ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-6 py-8 text-center text-gray-500">No classes scheduled for today.</div>
            @endif
        </div>
    </div>
</x-app-layout>

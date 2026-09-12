<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">Exam: {{ $exam->name }}</h2>
    </x-slot>

    <div class="space-y-6">
        {{-- Exam Info Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Subject</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $exam->subject->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Class</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $exam->classroom->name ?? '-' }}-{{ $exam->classroom->section ?? '' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Date</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $exam->date?->format('M d, Y') ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Max Marks</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $exam->max_marks }}</p>
                </div>
            </div>
            <div class="mt-6 flex space-x-3">
                <a href="{{ route('grades.entry', $exam) }}" class="bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1 rounded-full hover:bg-emerald-100 transition">Enter Marks</a>
                <a href="{{ route('grades.edit', $exam) }}" class="bg-amber-50 text-amber-700 text-xs font-semibold px-3 py-1 rounded-full hover:bg-amber-100 transition">Edit</a>
                <a href="{{ route('grades.index') }}" class="bg-white border-2 border-gray-200 text-gray-700 hover:bg-gray-50 font-semibold py-2 px-4 rounded-xl transition text-sm">Back to List</a>
            </div>
        </div>

        {{-- Grades Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Grades</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Student</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Marks</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Percentage</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($exam->grades as $grade)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                    <a href="{{ route('grades.report-card', $grade->student_id) }}" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm">{{ $grade->student->full_name ?? '-' }}</a>
                                </td>
                                <td class="px-6 py-4 text-center text-sm font-semibold text-gray-900">{{ $grade->marks_obtained ?? '-' }}</td>
                                <td class="px-6 py-4 text-center text-sm">
                                    @php $pct = $exam->max_marks > 0 ? round(($grade->marks_obtained ?? 0) / $exam->max_marks * 100, 1) : 0; @endphp
                                    @if($pct >= 50)
                                        <span class="bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $pct }}%</span>
                                    @else
                                        <span class="bg-red-50 text-red-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $pct }}%</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $grade->remarks ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="bg-gray-50 rounded-xl p-8 inline-block">
                                        <p class="text-4xl mb-3">📝</p>
                                        <p class="text-gray-500 font-medium">No grades entered yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

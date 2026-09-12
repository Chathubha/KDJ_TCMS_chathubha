<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Exam: {{ $exam->name }}</h2>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div><p class="text-sm text-gray-500">Subject</p><p class="font-medium">{{ $exam->subject->name ?? '-' }}</p></div>
                <div><p class="text-sm text-gray-500">Class</p><p class="font-medium">{{ $exam->classroom->name ?? '-' }}-{{ $exam->classroom->section ?? '' }}</p></div>
                <div><p class="text-sm text-gray-500">Date</p><p class="font-medium">{{ $exam->date?->format('M d, Y') ?? '-' }}</p></div>
                <div><p class="text-sm text-gray-500">Max Marks</p><p class="font-medium">{{ $exam->max_marks }}</p></div>
            </div>
            <div class="mt-4 flex space-x-3">
                <a href="{{ route('grades.entry', $exam) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">Enter Marks</a>
                <a href="{{ route('grades.edit', $exam) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">Edit</a>
                <a href="{{ route('grades.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm">Back to List</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200"><h3 class="text-lg font-semibold">Grades</h3></div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Marks</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Percentage</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Remarks</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($exam->grades as $grade)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                <a href="{{ route('grades.report-card', $grade->student_id) }}" class="text-blue-600 hover:text-blue-900">{{ $grade->student->full_name ?? '-' }}</a>
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-medium">{{ $grade->marks_obtained ?? '-' }}</td>
                            <td class="px-6 py-4 text-center text-sm">
                                @php $pct = $exam->max_marks > 0 ? round(($grade->marks_obtained ?? 0) / $exam->max_marks * 100, 1) : 0; @endphp
                                <span class="{{ $pct >= 50 ? 'text-green-600' : 'text-red-600' }} font-bold">{{ $pct }}%</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $grade->remarks ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">No grades entered yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

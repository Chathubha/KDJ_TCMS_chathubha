<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">Enter Marks: {{ $exam->name }}</h2>
    </x-slot>

    <div class="space-y-6">
        {{-- Exam Info --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex flex-wrap gap-6 text-sm">
                <div>
                    <span class="text-gray-500">Subject:</span>
                    <span class="font-semibold text-gray-900 ml-2">{{ $exam->subject->name ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Class:</span>
                    <span class="font-semibold text-gray-900 ml-2">{{ $exam->classroom->name ?? '-' }}-{{ $exam->classroom->section ?? '' }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Max Marks:</span>
                    <span class="font-semibold text-gray-900 ml-2">{{ $exam->max_marks }}</span>
                </div>
            </div>
        </div>

        {{-- Marks Entry Form --}}
        <form method="POST" action="{{ route('grades.store-grades', $exam) }}">
            @csrf
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Marks (out of {{ $exam->max_marks }})</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($students as $index => $student)
                                @php $existing = $student->grades->first(); @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $student->full_name }}</td>
                                    <td class="px-6 py-4">
                                        <input type="number" name="grades[{{ $student->id }}][marks_obtained]" value="{{ $existing?->marks_obtained }}" class="w-28 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none" min="0" max="{{ $exam->max_marks }}" step="0.5">
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="grades[{{ $student->id }}][remarks]" value="{{ $existing?->remarks }}" class="w-48 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none" placeholder="Optional">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-xl transition shadow-sm">Save Grades</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>

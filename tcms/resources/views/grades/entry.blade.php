<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Enter Marks: {{ $exam->name }} ({{ $exam->subject->name ?? '-' }}) - Max: {{ $exam->max_marks }}</h2>
    </x-slot>

    <div class="space-y-6">
        <form method="POST" action="{{ route('grades.store-grades', $exam) }}">
            @csrf
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Marks (out of {{ $exam->max_marks }})</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($students as $index => $student)
                            @php $existing = $student->grades->first(); @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 text-sm text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-3 text-sm font-medium text-gray-900">{{ $student->full_name }}</td>
                                <td class="px-6 py-3">
                                    <input type="number" name="grades[{{ $student->id }}][marks_obtained]" value="{{ $existing?->marks_obtained }}" class="border-gray-300 rounded text-sm w-24" min="0" max="{{ $exam->max_marks }}" step="0.5">
                                </td>
                                <td class="px-6 py-3">
                                    <input type="text" name="grades[{{ $student->id }}][remarks]" value="{{ $existing?->remarks }}" class="border-gray-300 rounded text-sm w-48" placeholder="Optional">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">Save Grades</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>

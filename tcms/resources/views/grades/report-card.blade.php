<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Report Card: {{ $student->full_name }}</h2>
    </x-slot>

    <div class="max-w-3xl space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div><p class="text-sm text-gray-500">Student</p><p class="font-medium text-lg">{{ $student->full_name }}</p></div>
                <div><p class="text-sm text-gray-500">Class</p><p class="font-medium text-lg">{{ $classroom?->name ?? '-' }}-{{ $classroom?->section ?? '' }}</p></div>
            </div>

            @if(count($grades) > 0)
                <table class="min-w-full divide-y divide-gray-200 mb-6">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Exam</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Marks</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Max</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">%</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($grades as $g)
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium">{{ $g['subject'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $g['exam'] }}</td>
                                <td class="px-4 py-3 text-center text-sm font-medium">{{ $g['marks'] }}</td>
                                <td class="px-4 py-3 text-center text-sm text-gray-500">{{ $g['max_marks'] }}</td>
                                <td class="px-4 py-3 text-center text-sm font-bold {{ $g['percentage'] >= 50 ? 'text-green-600' : 'text-red-600' }}">{{ $g['percentage'] }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex justify-between text-lg">
                        <span class="font-semibold">Overall:</span>
                        <span class="font-bold {{ $overallPercentage >= 50 ? 'text-green-600' : 'text-red-600' }}">{{ $totalMarks }} / {{ $totalMax }} ({{ $overallPercentage }}%)</span>
                    </div>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No grades available.</p>
            @endif

            <div class="mt-6">
                <a href="javascript:window.print()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">Print Report Card</a>
            </div>
        </div>
    </div>
</x-app-layout>

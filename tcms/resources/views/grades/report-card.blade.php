<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">Report Card: {{ $student->full_name }}</h2>
    </x-slot>

    <div class="max-w-3xl space-y-6">
        {{-- Student Info --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Student</p>
                    <p class="text-lg font-bold text-gray-900">{{ $student->full_name }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Class</p>
                    <p class="text-lg font-bold text-gray-900">{{ $classroom?->name ?? '-' }}-{{ $classroom?->section ?? '' }}</p>
                </div>
            </div>

            @if(count($grades) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 mb-6">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Subject</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Exam</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Marks</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Max</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">%</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($grades as $g)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ $g['subject'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $g['exam'] }}</td>
                                    <td class="px-4 py-3 text-center text-sm font-semibold text-gray-900">{{ $g['marks'] }}</td>
                                    <td class="px-4 py-3 text-center text-sm text-gray-500">{{ $g['max_marks'] }}</td>
                                    <td class="px-4 py-3 text-center">
                                        @if($g['percentage'] >= 50)
                                            <span class="bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $g['percentage'] }}%</span>
                                        @else
                                            <span class="bg-red-50 text-red-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $g['percentage'] }}%</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-700">Overall:</span>
                        <span class="text-lg font-bold {{ $overallPercentage >= 50 ? 'text-emerald-700' : 'text-red-700' }}">{{ $totalMarks }} / {{ $totalMax }} ({{ $overallPercentage }}%)</span>
                    </div>
                </div>
            @else
                <div class="bg-gray-50 rounded-xl p-8 text-center">
                    <p class="text-4xl mb-3">📝</p>
                    <p class="text-gray-500 font-medium">No grades available.</p>
                </div>
            @endif

            <div class="mt-6">
                <a href="javascript:window.print()" class="bg-white border-2 border-gray-200 text-gray-700 hover:bg-gray-50 font-semibold py-3 px-6 rounded-xl transition text-sm">🖨️ Print Report Card</a>
            </div>
        </div>
    </div>
</x-app-layout>

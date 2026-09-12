<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">Attendance Report</h2>
    </x-slot>

    <div class="space-y-6">
        {{-- Class Selector --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <form method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
                <div class="flex-1 w-full">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Class *</label>
                    <select name="classroom_id" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                        <option value="">Select Class</option>
                        @foreach($classrooms as $class)
                            <option value="{{ $class->id }}" {{ $classroomId == $class->id ? 'selected' : '' }}>{{ $class->name }}-{{ $class->section }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-xl transition shadow-sm whitespace-nowrap">
                    Generate Report
                </button>
            </form>
        </div>

        {{-- Report Table --}}
        @if(count($report) > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Report <span class="text-sm font-medium text-gray-500">({{ $totalDays }} days recorded)</span></h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Present</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Late</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Absent</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Percentage</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($report as $row)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $row['student']->full_name }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $row['present'] }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="bg-amber-50 text-amber-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $row['late'] }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="bg-red-50 text-red-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $row['absent'] }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm font-semibold text-gray-700">{{ $row['total'] }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $pctClasses = $row['percentage'] >= 75
                                                ? 'bg-emerald-50 text-emerald-700'
                                                : 'bg-red-50 text-red-700';
                                        @endphp
                                        <span class="inline-block {{ $pctClasses }} text-xs font-bold px-3 py-1 rounded-full">{{ $row['percentage'] }}%</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif($classroomId)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="flex flex-col items-center">
                    <span class="text-4xl mb-3">📊</span>
                    <p class="text-gray-500 font-medium">No attendance data for this class.</p>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>

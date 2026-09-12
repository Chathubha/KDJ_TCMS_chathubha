<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Attendance Report</h2>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-4">
            <form method="GET" class="flex gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Class *</label>
                    <select name="classroom_id" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                        <option value="">Select Class</option>
                        @foreach($classrooms as $class)
                            <option value="{{ $class->id }}" {{ $classroomId == $class->id ? 'selected' : '' }}>{{ $class->name }}-{{ $class->section }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg">Generate Report</button>
            </form>
        </div>

        @if(count($report) > 0)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold">Report ({{ $totalDays }} days recorded)</h3>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Present</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Late</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Absent</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Percentage</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($report as $row)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $row['student']->full_name }}</td>
                                <td class="px-6 py-4 text-center text-sm text-green-600 font-medium">{{ $row['present'] }}</td>
                                <td class="px-6 py-4 text-center text-sm text-yellow-600 font-medium">{{ $row['late'] }}</td>
                                <td class="px-6 py-4 text-center text-sm text-red-600 font-medium">{{ $row['absent'] }}</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-700">{{ $row['total'] }}</td>
                                <td class="px-6 py-4 text-center text-sm font-bold {{ $row['percentage'] >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $row['percentage'] }}%
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif($classroomId)
            <div class="bg-white rounded-lg shadow p-8 text-center text-gray-500">No attendance data for this class.</div>
        @endif
    </div>
</x-app-layout>

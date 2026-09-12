<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Attendance History</h2>
            <a href="{{ route('attendance.mark') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Mark Attendance</a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-4">
            <form method="GET" class="flex gap-4">
                <select name="classroom_id" class="border border-gray-300 rounded-lg px-4 py-2">
                    <option value="">All Classes</option>
                    @foreach($classrooms as $class)
                        <option value="{{ $class->id }}" {{ request('classroom_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}-{{ $class->section }}</option>
                    @endforeach
                </select>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="border border-gray-300 rounded-lg px-4 py-2" placeholder="From">
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="border border-gray-300 rounded-lg px-4 py-2" placeholder="To">
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">Filter</button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Remarks</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($attendances as $att)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $att->date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $att->student->full_name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $att->classroom->name ?? '-' }}-{{ $att->classroom->section ?? '' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $colors = ['present' => 'green', 'absent' => 'red', 'late' => 'yellow', 'excused' => 'blue'];
                                    $color = $colors[$att->status] ?? 'gray';
                                @endphp
                                <span class="bg-{{ $color }}-100 text-{{ $color }}-800 text-xs px-2 py-1 rounded-full capitalize">{{ $att->status }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $att->remarks ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">No attendance records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">{{ $attendances->withQueryString()->links() }}</div>
        </div>
    </div>
</x-app-layout>

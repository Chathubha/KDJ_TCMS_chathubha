<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Schedule / Timetable</h2>
            <a href="{{ route('schedule.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Add Schedule</a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-4">
            <form method="GET" class="flex gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Class</label>
                    <select name="classroom_id" class="w-full border-gray-300 rounded-lg shadow-sm">
                        <option value="">Select Class</option>
                        @foreach($classrooms as $class)
                            <option value="{{ $class->id }}" {{ $classroomId == $class->id ? 'selected' : '' }}>{{ $class->name }}-{{ $class->section }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg">View Timetable</button>
            </form>
        </div>

        @if($timetable)
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <table class="min-w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="border border-gray-200 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Period</th>
                            @foreach($timetable['days'] as $day)
                                <th class="border border-gray-200 px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">{{ ucfirst($day) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($timetable['periods'] as $period)
                            <tr>
                                <td class="border border-gray-200 px-4 py-3 text-sm font-medium bg-gray-50">
                                    {{ $period->name }}<br>
                                    <span class="text-xs text-gray-400">{{ $period->start_time }} - {{ $period->end_time }}</span>
                                </td>
                                @foreach($timetable['days'] as $day)
                                    @php $slot = $timetable[$day][$period->id] ?? null; @endphp
                                    <td class="border border-gray-200 px-3 py-2 text-center text-sm">
                                        @if($slot)
                                            <div class="bg-blue-50 rounded p-2">
                                                <div class="font-medium text-blue-800">{{ $slot->subject->name ?? '-' }}</div>
                                                <div class="text-xs text-blue-600">{{ $slot->teacher->full_name ?? '-' }}</div>
                                                <a href="{{ route('schedule.edit', $slot) }}" class="text-xs text-yellow-600 hover:text-yellow-800">Edit</a>
                                                <form method="POST" action="{{ route('schedule.destroy', $slot) }}" class="inline" onsubmit="return confirm('Delete?')">
                                                    @csrf @method('DELETE')
                                                    <button class="text-xs text-red-600 hover:text-red-800">Del</button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>

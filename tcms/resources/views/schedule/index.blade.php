<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900">Schedule / Timetable</h2>
            <a href="{{ route('schedule.create') }}" class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-xl transition shadow-sm text-sm">+ Add Schedule</a>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Class Selector --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <form method="GET" class="flex gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Select Class</label>
                    <select name="classroom_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                        <option value="">Select Class</option>
                        @foreach($classrooms as $class)
                            <option value="{{ $class->id }}" {{ $classroomId == $class->id ? 'selected' : '' }}>{{ $class->name }}-{{ $class->section }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-xl transition shadow-sm">View Timetable</button>
            </form>
        </div>

        {{-- Timetable Grid --}}
        @if($timetable)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Period</th>
                                @foreach($timetable['days'] as $day)
                                    <th class="px-4 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">{{ ucfirst($day) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($timetable['periods'] as $period)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-4 bg-gray-50 border-r border-gray-100">
                                        <p class="text-sm font-semibold text-gray-900">{{ $period->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $period->start_time }} - {{ $period->end_time }}</p>
                                    </td>
                                    @foreach($timetable['days'] as $day)
                                        @php $slot = $timetable[$day][$period->id] ?? null; @endphp
                                        <td class="px-3 py-3 text-center border-r border-gray-50 last:border-r-0">
                                            @if($slot)
                                                <div class="bg-blue-50 rounded-xl p-3">
                                                    <p class="text-sm font-semibold text-blue-800">{{ $slot->subject->name ?? '-' }}</p>
                                                    <p class="text-xs text-blue-600 mt-1">{{ $slot->teacher->full_name ?? '-' }}</p>
                                                    <div class="mt-2 space-x-2">
                                                        <a href="{{ route('schedule.edit', $slot) }}" class="text-xs text-amber-600 hover:text-amber-700 font-semibold">Edit</a>
                                                        <form method="POST" action="{{ route('schedule.destroy', $slot) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete?')">
                                                            @csrf @method('DELETE')
                                                            <button class="text-xs text-red-600 hover:text-red-700 font-semibold">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-gray-300 text-lg">—</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="bg-gray-50 rounded-xl p-8 inline-block">
                    <p class="text-4xl mb-3">📅</p>
                    <p class="text-gray-500 font-medium">Select a class to view the timetable.</p>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>

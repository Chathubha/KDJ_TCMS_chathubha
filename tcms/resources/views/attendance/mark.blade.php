<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Mark Attendance</h2>
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
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date *</label>
                    <input type="date" name="date" value="{{ $date }}" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                </div>
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg">Load Students</button>
            </form>
        </div>

        @if($students->count() > 0)
            <form method="POST" action="{{ route('attendance.store') }}">
                @csrf
                <input type="hidden" name="classroom_id" value="{{ $classroomId }}">
                <input type="hidden" name="date" value="{{ $date }}">

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Students ({{ $students->count() }})</h3>
                        <div class="flex gap-2">
                            <button type="button" onclick="markAll('present')" class="bg-green-100 text-green-700 px-3 py-1 rounded text-sm">All Present</button>
                            <button type="button" onclick="markAll('absent')" class="bg-red-100 text-red-700 px-3 py-1 rounded text-sm">All Absent</button>
                        </div>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($students as $index => $student)
                                @php
                                    $existing = $student->attendances->first();
                                    $currentStatus = $existing->status ?? 'present';
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-3 text-sm text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-6 py-3 text-sm font-medium text-gray-900">{{ $student->full_name }}</td>
                                    <td class="px-6 py-3">
                                        <div class="flex gap-2">
                                            @foreach(['present', 'absent', 'late', 'excused'] as $status)
                                                <label class="flex items-center">
                                                    <input type="radio" name="attendances[{{ $student->id }}][status]" value="{{ $status }}" {{ $currentStatus === $status ? 'checked' : '' }} class="mr-1">
                                                    <span class="text-xs capitalize">{{ $status }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-3">
                                        <select name="attendances[{{ $student->id }}][subject_id]" class="border-gray-300 rounded text-sm">
                                            <option value="">General</option>
                                            @foreach($subjects as $subject)
                                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-6 py-3">
                                        <input type="text" name="attendances[{{ $student->id }}][remarks]" class="border-gray-300 rounded text-sm w-32" placeholder="Optional">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">Save Attendance</button>
                    </div>
                </div>
            </form>
        @endif
    </div>

    <script>
        function markAll(status) {
            document.querySelectorAll('input[type="radio"][value="' + status + '"]').forEach(r => r.checked = true);
        }
    </script>
</x-app-layout>

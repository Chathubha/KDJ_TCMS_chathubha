<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">Mark Attendance</h2>
    </x-slot>

    <div class="space-y-6">
        {{-- Class & Date Selector --}}
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
                <div class="flex-1 w-full">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Date *</label>
                    <input type="date" name="date" value="{{ $date }}" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                </div>
                <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-xl transition shadow-sm whitespace-nowrap">
                    Load Students
                </button>
            </form>
        </div>

        {{-- Student Attendance Form --}}
        @if($students->count() > 0)
            <form method="POST" action="{{ route('attendance.store') }}">
                @csrf
                <input type="hidden" name="classroom_id" value="{{ $classroomId }}">
                <input type="hidden" name="date" value="{{ $date }}">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    {{-- Header with All Present / All Absent --}}
                    <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                        <h3 class="text-lg font-bold text-gray-900">Students ({{ $students->count() }})</h3>
                        <div class="flex gap-2">
                            <button type="button" onclick="markAll('present')"
                                class="bg-emerald-50 text-emerald-700 hover:bg-emerald-100 text-xs font-semibold px-4 py-2 rounded-full transition">
                                All Present
                            </button>
                            <button type="button" onclick="markAll('absent')"
                                class="bg-red-50 text-red-700 hover:bg-red-100 text-xs font-semibold px-4 py-2 rounded-full transition">
                                All Absent
                            </button>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Student</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Subject</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Remarks</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($students as $index => $student)
                                    @php
                                        $existing = $student->attendances->first();
                                        $currentStatus = $existing->status ?? 'present';
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-3 text-sm text-gray-500">{{ $index + 1 }}</td>
                                        <td class="px-6 py-3 text-sm font-semibold text-gray-900">{{ $student->full_name }}</td>
                                        <td class="px-6 py-3">
                                            <div class="flex gap-1">
                                                @php
                                                    $pillColors = [
                                                        'present' => ['active' => 'bg-emerald-600 text-white', 'inactive' => 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100'],
                                                        'absent'  => ['active' => 'bg-red-600 text-white', 'inactive' => 'bg-red-50 text-red-700 hover:bg-red-100'],
                                                        'late'    => ['active' => 'bg-amber-500 text-white', 'inactive' => 'bg-amber-50 text-amber-700 hover:bg-amber-100'],
                                                        'excused' => ['active' => 'bg-blue-600 text-white', 'inactive' => 'bg-blue-50 text-blue-700 hover:bg-blue-100'],
                                                    ];
                                                @endphp
                                                @foreach(['present', 'absent', 'late', 'excused'] as $status)
                                                    <label class="cursor-pointer">
                                                        <input type="radio" name="attendances[{{ $student->id }}][status]" value="{{ $status }}"
                                                            {{ $currentStatus === $status ? 'checked' : '' }} class="sr-only peer">
                                                        <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full transition {{ $currentStatus === $status ? $pillColors[$status]['active'] : $pillColors[$status]['inactive'] }} peer-checked:{{ $pillColors[$status]['active'] }}">
                                                            {{ ucfirst($status) }}
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-3">
                                            <select name="attendances[{{ $student->id }}][subject_id]"
                                                class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                                                <option value="">General</option>
                                                @foreach($subjects as $subject)
                                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-6 py-3">
                                            <input type="text" name="attendances[{{ $student->id }}][remarks]" placeholder="Optional"
                                                class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Footer --}}
                    <div class="px-6 py-4 border-t border-gray-100 flex justify-end">
                        <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-xl transition shadow-sm">
                            Save Attendance
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>

    <script>
        function markAll(status) {
            document.querySelectorAll('input[type="radio"][value="' + status + '"]').forEach(function(r) {
                r.checked = true;
                r.dispatchEvent(new Event('change', { bubbles: true }));
            });
            // Update pill visuals
            updatePills();
        }

        function updatePills() {
            document.querySelectorAll('input[type="radio"][attendances]').forEach(function(radio) {
                // Trigger label style update on check
            });
        }
    </script>
</x-app-layout>

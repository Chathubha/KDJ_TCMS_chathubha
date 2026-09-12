<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">Class: {{ $classroom->name }}-{{ $classroom->section }}</h2>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1">Class</p>
                    <p class="text-gray-900 font-medium text-lg">{{ $classroom->name }}-{{ $classroom->section }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1">Students</p>
                    <div class="mt-1">
                        @if($studentCount >= $classroom->capacity)
                            <span class="bg-red-50 text-red-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $studentCount }} / {{ $classroom->capacity }}</span>
                        @else
                            <span class="bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $studentCount }} / {{ $classroom->capacity }}</span>
                        @endif
                    </div>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1">Class Teacher</p>
                    <p class="text-gray-900 font-medium">{{ $classroom->classTeacher?->full_name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1">Academic Year</p>
                    <p class="text-gray-900 font-medium">{{ $classroom->academic_year }}</p>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100 flex space-x-3">
                <a href="{{ route('classrooms.edit', $classroom) }}" class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded-xl transition shadow-sm text-sm">Edit</a>
                <a href="{{ route('classrooms.index') }}" class="bg-white border-2 border-gray-200 text-gray-700 hover:bg-gray-50 font-semibold py-2 px-4 rounded-xl transition text-sm">Back to List</a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Enrolled Students</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Phone</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($classroom->students as $index => $student)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    <a href="{{ route('students.show', $student) }}" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm">{{ $student->full_name }}</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->user->email ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->phone ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="rounded-xl bg-gray-50 p-6 inline-block">
                                        <p class="text-3xl mb-2">📚</p>
                                        <p class="text-gray-500 text-sm font-medium">No students enrolled.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

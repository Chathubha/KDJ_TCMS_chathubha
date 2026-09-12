<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Class: {{ $classroom->name }}-{{ $classroom->section }}</h2>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Class</p>
                    <p class="font-medium text-lg">{{ $classroom->name }}-{{ $classroom->section }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Students</p>
                    <p class="font-medium text-lg">{{ $studentCount }} / {{ $classroom->capacity }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Class Teacher</p>
                    <p class="font-medium">{{ $classroom->classTeacher?->full_name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Academic Year</p>
                    <p class="font-medium">{{ $classroom->academic_year }}</p>
                </div>
            </div>
            <div class="mt-4 flex space-x-3">
                <a href="{{ route('classrooms.edit', $classroom) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">Edit</a>
                <a href="{{ route('classrooms.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm">Back to List</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Enrolled Students</h3>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($classroom->students as $index => $student)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <a href="{{ route('students.show', $student) }}" class="text-blue-600 hover:text-blue-900">{{ $student->full_name }}</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->user->email ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->phone ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">No students enrolled.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

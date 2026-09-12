<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Classes</h2>
            <a href="{{ route('classrooms.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Add Class</a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-4">
            <form method="GET" class="flex gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or section..." class="border border-gray-300 rounded-lg px-4 py-2 flex-1">
                <input type="text" name="academic_year" value="{{ request('academic_year') }}" placeholder="Academic Year" class="border border-gray-300 rounded-lg px-4 py-2 w-40">
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">Filter</button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Section</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Students</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Capacity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class Teacher</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Year</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($classrooms as $classroom)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $classroom->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $classroom->section }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="{{ $classroom->students_count >= $classroom->capacity ? 'text-red-600 font-bold' : '' }}">
                                    {{ $classroom->students_count }} / {{ $classroom->capacity }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $classroom->capacity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $classroom->classTeacher?->full_name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $classroom->academic_year }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('classrooms.show', $classroom) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                <a href="{{ route('classrooms.edit', $classroom) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                <form method="POST" action="{{ route('classrooms.destroy', $classroom) }}" class="inline" onsubmit="return confirm('Delete this class?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">No classes found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">{{ $classrooms->withQueryString()->links() }}</div>
        </div>
    </div>
</x-app-layout>

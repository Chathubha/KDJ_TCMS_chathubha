<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900">Classes</h2>
            <a href="{{ route('classrooms.create') }}" class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-xl transition shadow-sm text-sm">+ Add Class</a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <form method="GET" class="flex gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or section..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none flex-1">
                <input type="text" name="academic_year" value="{{ request('academic_year') }}" placeholder="Academic Year" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none w-40">
                <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-xl transition shadow-sm">Filter</button>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Class</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Section</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Students</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Capacity</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Class Teacher</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Year</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($classrooms as $classroom)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $classroom->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $classroom->section }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($classroom->students_count >= $classroom->capacity)
                                        <span class="bg-red-50 text-red-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $classroom->students_count }} / {{ $classroom->capacity }}</span>
                                    @else
                                        <span class="bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $classroom->students_count }} / {{ $classroom->capacity }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $classroom->capacity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $classroom->classTeacher?->full_name ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $classroom->academic_year }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                    <a href="{{ route('classrooms.show', $classroom) }}" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm">View</a>
                                    <a href="{{ route('classrooms.edit', $classroom) }}" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm">Edit</a>
                                    <form method="POST" action="{{ route('classrooms.destroy', $classroom) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 font-semibold text-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="rounded-xl bg-gray-50 p-6 inline-block">
                                        <p class="text-3xl mb-2">🏫</p>
                                        <p class="text-gray-500 text-sm font-medium">No classes found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100">{{ $classrooms->withQueryString()->links() }}</div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Subjects</h2>
            <a href="{{ route('subjects.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Add Subject</a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-4">
            <form method="GET" class="flex gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or code..." class="border border-gray-300 rounded-lg px-4 py-2 flex-1">
                <select name="classroom_id" class="border border-gray-300 rounded-lg px-4 py-2">
                    <option value="">All Classes</option>
                    @foreach($classrooms as $class)
                        <option value="{{ $class->id }}" {{ request('classroom_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}-{{ $class->section }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">Filter</button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teachers</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($subjects as $subject)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $subject->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $subject->code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $subject->classroom->name ?? '-' }}-{{ $subject->classroom->section ?? '' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @foreach($subject->teachers as $teacher)
                                    <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full mr-1">{{ $teacher->full_name }}</span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('subjects.show', $subject) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                <a href="{{ route('subjects.edit', $subject) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                <form method="POST" action="{{ route('subjects.destroy', $subject) }}" class="inline" onsubmit="return confirm('Delete this subject?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">No subjects found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">{{ $subjects->withQueryString()->links() }}</div>
        </div>
    </div>
</x-app-layout>

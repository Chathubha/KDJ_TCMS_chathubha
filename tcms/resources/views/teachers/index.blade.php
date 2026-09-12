<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Teachers</h2>
            <a href="{{ route('teachers.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Add Teacher</a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-4">
            <form method="GET" class="flex gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or phone..." class="border border-gray-300 rounded-lg px-4 py-2 flex-1">
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">Search</button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qualification</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subjects</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($teachers as $teacher)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $teacher->full_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $teacher->user->email ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $teacher->qualification ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @foreach($teacher->subjects as $subject)
                                    <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full mr-1">{{ $subject->name }}</span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $teacher->phone ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('teachers.show', $teacher) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                <a href="{{ route('teachers.edit', $teacher) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                <form method="POST" action="{{ route('teachers.destroy', $teacher) }}" class="inline" onsubmit="return confirm('Delete this teacher?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">No teachers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">{{ $teachers->withQueryString()->links() }}</div>
        </div>
    </div>
</x-app-layout>

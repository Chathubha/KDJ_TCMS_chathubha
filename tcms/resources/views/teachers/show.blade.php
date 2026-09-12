<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Teacher Profile: {{ $teacher->full_name }}</h2>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Full Name</p>
                    <p class="font-medium">{{ $teacher->full_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium">{{ $teacher->user->email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Phone</p>
                    <p class="font-medium">{{ $teacher->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Qualification</p>
                    <p class="font-medium">{{ $teacher->qualification ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Specialization</p>
                    <p class="font-medium">{{ $teacher->specialization ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Assigned Subjects</p>
                    <div class="flex flex-wrap gap-2 mt-1">
                        @forelse($teacher->subjects as $subject)
                            <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">{{ $subject->name }}</span>
                        @empty
                            <span class="text-gray-400">No subjects assigned</span>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="mt-6 flex space-x-3">
                <a href="{{ route('teachers.edit', $teacher) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">Edit</a>
                <a href="{{ route('teachers.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm">Back to List</a>
            </div>
        </div>
    </div>
</x-app-layout>

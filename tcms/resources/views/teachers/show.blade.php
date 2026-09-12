<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">Teacher Profile: {{ $teacher->full_name }}</h2>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1">Full Name</p>
                    <p class="text-gray-900 font-medium">{{ $teacher->full_name }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1">Email</p>
                    <p class="text-gray-900 font-medium">{{ $teacher->user->email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1">Phone</p>
                    <p class="text-gray-900 font-medium">{{ $teacher->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1">Qualification</p>
                    <p class="text-gray-900 font-medium">{{ $teacher->qualification ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1">Specialization</p>
                    <p class="text-gray-900 font-medium">{{ $teacher->specialization ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1">Assigned Subjects</p>
                    <div class="flex flex-wrap gap-2 mt-1">
                        @forelse($teacher->subjects as $subject)
                            <span class="bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $subject->name }}</span>
                        @empty
                            <span class="text-gray-400 text-sm">No subjects assigned</span>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100 flex space-x-3">
                <a href="{{ route('teachers.edit', $teacher) }}" class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded-xl transition shadow-sm text-sm">Edit</a>
                <a href="{{ route('teachers.index') }}" class="bg-white border-2 border-gray-200 text-gray-700 hover:bg-gray-50 font-semibold py-2 px-4 rounded-xl transition text-sm">Back to List</a>
            </div>
        </div>
    </div>
</x-app-layout>

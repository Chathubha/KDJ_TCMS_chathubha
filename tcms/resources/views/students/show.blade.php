<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Student Profile: {{ $student->full_name }}</h2>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Full Name</p>
                    <p class="font-medium">{{ $student->full_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium">{{ $student->user->email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Date of Birth</p>
                    <p class="font-medium">{{ $student->dob?->format('M d, Y') ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Gender</p>
                    <p class="font-medium capitalize">{{ $student->gender }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Phone</p>
                    <p class="font-medium">{{ $student->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Address</p>
                    <p class="font-medium">{{ $student->address ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Enrolled Classes</p>
                    <div class="flex flex-wrap gap-2 mt-1">
                        @forelse($student->classrooms as $class)
                            <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">{{ $class->name }}-{{ $class->section }} ({{ $class->pivot->academic_year }})</span>
                        @empty
                            <span class="text-gray-400">No classes</span>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="mt-6 flex space-x-3">
                <a href="{{ route('students.edit', $student) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">Edit</a>
                <a href="{{ route('students.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm">Back to List</a>
            </div>
        </div>
    </div>
</x-app-layout>

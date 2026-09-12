<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Subject: {{ $subject->name }}</h2>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Name</p>
                    <p class="font-medium">{{ $subject->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Code</p>
                    <p class="font-medium">{{ $subject->code }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Class</p>
                    <p class="font-medium">{{ $subject->classroom->name ?? '-' }}-{{ $subject->classroom->section ?? '' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Description</p>
                    <p class="font-medium">{{ $subject->description ?? '-' }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-500">Assigned Teachers</p>
                    <div class="flex flex-wrap gap-2 mt-1">
                        @forelse($subject->teachers as $teacher)
                            <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">{{ $teacher->full_name }}</span>
                        @empty
                            <span class="text-gray-400">No teachers assigned</span>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="mt-6 flex space-x-3">
                <a href="{{ route('subjects.edit', $subject) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">Edit</a>
                <a href="{{ route('subjects.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm">Back to List</a>
            </div>
        </div>
    </div>
</x-app-layout>

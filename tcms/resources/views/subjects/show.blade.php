<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">Subject Details</h2>
    </x-slot>

    <div class="max-w-2xl space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Subject Name</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $subject->name }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Code</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $subject->code }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Class</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $subject->classroom->name ?? '-' }}-{{ $subject->classroom->section ?? '' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Description</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $subject->description ?? '-' }}</p>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Assigned Teachers</p>
                <div class="flex flex-wrap gap-2">
                    @forelse($subject->teachers as $teacher)
                        <span class="bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $teacher->full_name }}</span>
                    @empty
                        <span class="text-gray-400 text-sm">No teachers assigned</span>
                    @endforelse
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100 flex justify-end space-x-3">
                <a href="{{ route('subjects.edit', $subject) }}" class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-xl transition shadow-sm text-sm">Edit</a>
                <a href="{{ route('subjects.index') }}" class="bg-white border-2 border-gray-200 text-gray-700 hover:bg-gray-50 font-semibold py-3 px-6 rounded-xl transition text-sm">Back to List</a>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Edit Teacher: {{ $teacher->full_name }}</h2>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('teachers.update', $teacher) }}" class="space-y-4">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">First Name *</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $teacher->first_name) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Last Name *</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $teacher->last_name) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $teacher->phone) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Qualification</label>
                        <input type="text" name="qualification" value="{{ old('qualification', $teacher->qualification) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Specialization</label>
                    <input type="text" name="specialization" value="{{ old('specialization', $teacher->specialization) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Assign Subjects</label>
                    <div class="grid grid-cols-3 gap-2 max-h-40 overflow-y-auto border border-gray-200 rounded-lg p-3">
                        @foreach($subjects as $subject)
                            <label class="flex items-center space-x-2 text-sm">
                                <input type="checkbox" name="subject_ids[]" value="{{ $subject->id }}" {{ $teacher->subjects->contains($subject->id) ? 'checked' : '' }}>
                                <span>{{ $subject->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <a href="{{ route('teachers.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">Cancel</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Update Teacher</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

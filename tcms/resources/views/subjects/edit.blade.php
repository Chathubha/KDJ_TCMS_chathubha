<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Edit Subject: {{ $subject->name }}</h2>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('subjects.update', $subject) }}" class="space-y-4">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Subject Name *</label>
                        <input type="text" name="name" value="{{ old('name', $subject->name) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Code *</label>
                        <input type="text" name="code" value="{{ old('code', $subject->code) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Class *</label>
                    <select name="classroom_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                        <option value="">Select Class</option>
                        @foreach($classrooms as $class)
                            <option value="{{ $class->id }}" {{ old('classroom_id', $subject->classroom_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}-{{ $class->section }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">{{ old('description', $subject->description) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Assign Teachers</label>
                    <div class="grid grid-cols-3 gap-2 max-h-40 overflow-y-auto border border-gray-200 rounded-lg p-3">
                        @foreach($teachers as $teacher)
                            <label class="flex items-center space-x-2 text-sm">
                                <input type="checkbox" name="teacher_ids[]" value="{{ $teacher->id }}" {{ $subject->teachers->contains($teacher->id) ? 'checked' : '' }}>
                                <span>{{ $teacher->full_name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <a href="{{ route('subjects.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">Cancel</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Update Subject</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

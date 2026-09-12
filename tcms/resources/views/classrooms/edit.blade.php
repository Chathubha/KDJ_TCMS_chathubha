<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Edit Class: {{ $classroom->name }}-{{ $classroom->section }}</h2>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('classrooms.update', $classroom) }}" class="space-y-4">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Class Name *</label>
                        <input type="text" name="name" value="{{ old('name', $classroom->name) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Section *</label>
                        <input type="text" name="section" value="{{ old('section', $classroom->section) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Capacity *</label>
                        <input type="number" name="capacity" value="{{ old('capacity', $classroom->capacity) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" min="1" max="100" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Academic Year *</label>
                        <input type="text" name="academic_year" value="{{ old('academic_year', $classroom->academic_year) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Class Teacher</label>
                    <select name="class_teacher_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                        <option value="">Select Teacher</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('class_teacher_id', $classroom->class_teacher_id) == $teacher->id ? 'selected' : '' }}>{{ $teacher->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <a href="{{ route('classrooms.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">Cancel</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Update Class</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

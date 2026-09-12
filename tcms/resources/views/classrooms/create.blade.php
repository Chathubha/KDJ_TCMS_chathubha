<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Add Class</h2>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('classrooms.store') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Class Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" placeholder="e.g. 10" required>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Section *</label>
                        <input type="text" name="section" value="{{ old('section') }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" placeholder="e.g. A" required>
                        @error('section') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Capacity *</label>
                        <input type="number" name="capacity" value="{{ old('capacity', 40) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" min="1" max="100" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Academic Year *</label>
                        <input type="text" name="academic_year" value="{{ old('academic_year', date('Y') . '-' . (date('Y') + 1)) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Class Teacher</label>
                    <select name="class_teacher_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                        <option value="">Select Teacher</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('class_teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <a href="{{ route('classrooms.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">Cancel</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Create Class</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

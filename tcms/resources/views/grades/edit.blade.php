<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Edit Exam: {{ $exam->name }}</h2>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('grades.update', $exam) }}" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700">Exam Name *</label>
                    <input type="text" name="name" value="{{ old('name', $exam->name) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Class *</label>
                        <select name="classroom_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                            @foreach($classrooms as $class)
                                <option value="{{ $class->id }}" {{ old('classroom_id', $exam->classroom_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}-{{ $class->section }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Subject *</label>
                        <select name="subject_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ old('subject_id', $exam->subject_id) == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="date" value="{{ old('date', $exam->date?->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Max Marks *</label>
                        <input type="number" name="max_marks" value="{{ old('max_marks', $exam->max_marks) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" min="1" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Weight *</label>
                        <input type="number" name="weight" value="{{ old('weight', $exam->weight) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" min="1" required>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <a href="{{ route('grades.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">Cancel</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Update Exam</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

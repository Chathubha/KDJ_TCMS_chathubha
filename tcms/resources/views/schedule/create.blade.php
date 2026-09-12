<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Add Schedule Entry</h2>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('schedule.store') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Class *</label>
                        <select name="classroom_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                            <option value="">Select Class</option>
                            @foreach($classrooms as $class)
                                <option value="{{ $class->id }}" {{ old('classroom_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}-{{ $class->section }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Day *</label>
                        <select name="day" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                            @foreach($days as $day)
                                <option value="{{ $day }}" {{ old('day') == $day ? 'selected' : '' }}>{{ ucfirst($day) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Period *</label>
                        <select name="period_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                            <option value="">Select Period</option>
                            @foreach($periods as $period)
                                <option value="{{ $period->id }}" {{ old('period_id') == $period->id ? 'selected' : '' }}>{{ $period->name }} ({{ $period->start_time }}-{{ $period->end_time }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Subject *</label>
                        <select name="subject_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                            <option value="">Select Subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teacher *</label>
                        <select name="teacher_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                            <option value="">Select Teacher</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @error('teacher_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                <div class="flex justify-end space-x-3 pt-4">
                    <a href="{{ route('schedule.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">Cancel</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Add to Schedule</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

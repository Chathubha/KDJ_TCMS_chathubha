<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Edit Student: {{ $student->full_name }}</h2>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('students.update', $student) }}" class="space-y-4">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">First Name *</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $student->first_name) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                        @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Last Name *</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $student->last_name) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                        @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <input type="date" name="dob" value="{{ old('dob', $student->dob?->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gender *</label>
                        <select name="gender" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                            <option value="male" {{ old('gender', $student->gender) === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $student->gender) === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $student->gender) === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $student->phone) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea name="address" rows="3" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">{{ old('address', $student->address) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Assign to Class</label>
                    <select name="classroom_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                        <option value="">Select Class</option>
                        @foreach($classrooms as $class)
                            <option value="{{ $class->id }}" {{ old('classroom_id', $student->classrooms->first()?->id) == $class->id ? 'selected' : '' }}>{{ $class->name }}-{{ $class->section }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <a href="{{ route('students.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">Cancel</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Update Student</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

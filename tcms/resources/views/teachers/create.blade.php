<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Add Teacher</h2>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('teachers.store') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">First Name *</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                        @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Last Name *</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                        @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Qualification</label>
                        <input type="text" name="qualification" value="{{ old('qualification') }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" placeholder="e.g. M.Sc, B.Ed">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Specialization</label>
                    <input type="text" name="specialization" value="{{ old('specialization') }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" placeholder="e.g. Mathematics">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Assign Subjects</label>
                    <div class="grid grid-cols-3 gap-2 max-h-40 overflow-y-auto border border-gray-200 rounded-lg p-3">
                        @foreach($subjects as $subject)
                            <label class="flex items-center space-x-2 text-sm">
                                <input type="checkbox" name="subject_ids[]" value="{{ $subject->id }}" {{ in_array($subject->id, old('subject_ids', [])) ? 'checked' : '' }}>
                                <span>{{ $subject->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <a href="{{ route('teachers.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">Cancel</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Create Teacher</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

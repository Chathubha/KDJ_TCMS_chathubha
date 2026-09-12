<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">Add Fee</h2>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <form method="POST" action="{{ route('fees.store') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Fee Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none" placeholder="e.g. Tuition Fee - January" required>
                    @error('name') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Class *</label>
                        <select name="classroom_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none" required>
                            <option value="">Select Class</option>
                            @foreach($classrooms as $class)
                                <option value="{{ $class->id }}" {{ old('classroom_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}-{{ $class->section }}</option>
                            @endforeach
                        </select>
                        @error('classroom_id') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Type *</label>
                        <select name="type" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none" required>
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ old('type', 'tuition') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Amount (Rs.) *</label>
                        <input type="number" name="amount" value="{{ old('amount') }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none" min="0" step="0.01" required>
                        @error('amount') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Academic Year *</label>
                        <input type="text" name="academic_year" value="{{ old('academic_year', date('Y') . '-' . (date('Y') + 1)) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Due Date</label>
                    <input type="date" name="due_date" value="{{ old('due_date') }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none" placeholder="Optional description">{{ old('description') }}</textarea>
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('fees.index') }}" class="bg-white border-2 border-gray-200 text-gray-700 hover:bg-gray-50 font-semibold py-2.5 px-6 rounded-xl transition">Cancel</a>
                    <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-2.5 px-6 rounded-xl transition shadow-sm">Create Fee</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

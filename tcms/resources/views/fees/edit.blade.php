<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">Edit Fee: {{ $fee->name }}</h2>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <form method="POST" action="{{ route('fees.update', $fee) }}" class="space-y-5">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Fee Name *</label>
                    <input type="text" name="name" value="{{ old('name', $fee->name) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Class *</label>
                        <select name="classroom_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none" required>
                            @foreach($classrooms as $class)
                                <option value="{{ $class->id }}" {{ old('classroom_id', $fee->classroom_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}-{{ $class->section }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Type *</label>
                        <select name="type" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none" required>
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ old('type', $fee->type) == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Amount (Rs.) *</label>
                        <input type="number" name="amount" value="{{ old('amount', $fee->amount) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none" min="0" step="0.01" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Academic Year *</label>
                        <input type="text" name="academic_year" value="{{ old('academic_year', $fee->academic_year) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Due Date</label>
                    <input type="date" name="due_date" value="{{ old('due_date', $fee->due_date?->format('Y-m-d')) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">{{ old('description', $fee->description) }}</textarea>
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('fees.index') }}" class="bg-white border-2 border-gray-200 text-gray-700 hover:bg-gray-50 font-semibold py-2.5 px-6 rounded-xl transition">Cancel</a>
                    <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-2.5 px-6 rounded-xl transition shadow-sm">Update Fee</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

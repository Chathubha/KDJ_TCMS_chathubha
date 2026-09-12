<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900">Exams & Grades</h2>
            <a href="{{ route('grades.create') }}" class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-xl transition shadow-sm text-sm">+ Add Exam</a>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Filters --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <form method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Class</label>
                    <select name="classroom_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                        <option value="">All Classes</option>
                        @foreach($classrooms as $class)
                            <option value="{{ $class->id }}" {{ request('classroom_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}-{{ $class->section }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Subject</label>
                    <select name="subject_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                        <option value="">All Subjects</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-white border-2 border-gray-200 text-gray-700 hover:bg-gray-50 font-semibold py-3 px-6 rounded-xl transition text-sm">Filter</button>
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Exam</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Class</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Max Marks</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($exams as $exam)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $exam->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $exam->subject->name ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $exam->classroom->name ?? '-' }}-{{ $exam->classroom->section ?? '' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $exam->date?->format('M d, Y') ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $exam->max_marks }}</td>
                                <td class="px-6 py-4 text-right text-sm space-x-3">
                                    <a href="{{ route('grades.show', $exam) }}" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm">View</a>
                                    <a href="{{ route('grades.entry', $exam) }}" class="text-emerald-600 hover:text-emerald-700 font-semibold text-sm">Enter Marks</a>
                                    <a href="{{ route('grades.edit', $exam) }}" class="text-amber-600 hover:text-amber-700 font-semibold text-sm">Edit</a>
                                    <form method="POST" action="{{ route('grades.destroy', $exam) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 font-semibold text-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="bg-gray-50 rounded-xl p-8 inline-block">
                                        <p class="text-4xl mb-3">📋</p>
                                        <p class="text-gray-500 font-medium">No exams found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100">{{ $exams->withQueryString()->links() }}</div>
        </div>
    </div>
</x-app-layout>

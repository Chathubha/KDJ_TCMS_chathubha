<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Exams & Grades</h2>
            <a href="{{ route('grades.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Add Exam</a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-4">
            <form method="GET" class="flex gap-4">
                <select name="classroom_id" class="border border-gray-300 rounded-lg px-4 py-2">
                    <option value="">All Classes</option>
                    @foreach($classrooms as $class)
                        <option value="{{ $class->id }}" {{ request('classroom_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}-{{ $class->section }}</option>
                    @endforeach
                </select>
                <select name="subject_id" class="border border-gray-300 rounded-lg px-4 py-2">
                    <option value="">All Subjects</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">Filter</button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Exam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Max Marks</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($exams as $exam)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $exam->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $exam->subject->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $exam->classroom->name ?? '-' }}-{{ $exam->classroom->section ?? '' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $exam->date?->format('M d, Y') ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $exam->max_marks }}</td>
                            <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                                <a href="{{ route('grades.show', $exam) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                <a href="{{ route('grades.entry', $exam) }}" class="text-green-600 hover:text-green-900">Enter Marks</a>
                                <a href="{{ route('grades.edit', $exam) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                <form method="POST" action="{{ route('grades.destroy', $exam) }}" class="inline" onsubmit="return confirm('Delete this exam?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">No exams found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">{{ $exams->withQueryString()->links() }}</div>
        </div>
    </div>
</x-app-layout>

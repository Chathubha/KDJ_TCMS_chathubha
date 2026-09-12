<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Search Results</h2>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-4">
            <form method="GET" class="flex gap-4">
                <input type="text" name="q" value="{{ $query }}" placeholder="Search students, teachers, classes..." class="border border-gray-300 rounded-lg px-4 py-2 flex-1" autofocus>
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg">Search</button>
            </form>
        </div>

        @if(strlen($query) >= 2)
            @if($results['students']->count() > 0)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-blue-50">
                        <h3 class="text-lg font-semibold">Students ({{ $results['students']->count() }})</h3>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($results['students'] as $student)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <a href="{{ route('students.show', $student) }}" class="text-blue-600 hover:text-blue-900">{{ $student->full_name }}</a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $student->user->email ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        @foreach($student->classrooms as $c)
                                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">{{ $c->name }}-{{ $c->section }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if($results['teachers']->count() > 0)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-green-50">
                        <h3 class="text-lg font-semibold">Teachers ({{ $results['teachers']->count() }})</h3>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($results['teachers'] as $teacher)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <a href="{{ route('teachers.show', $teacher) }}" class="text-blue-600 hover:text-blue-900">{{ $teacher->full_name }}</a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $teacher->specialization ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if($results['classes']->count() > 0)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-yellow-50">
                        <h3 class="text-lg font-semibold">Classes ({{ $results['classes']->count() }})</h3>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($results['classes'] as $class)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <a href="{{ route('classrooms.show', $class) }}" class="text-blue-600 hover:text-blue-900">{{ $class->name }}-{{ $class->section }}</a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $class->academic_year }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if($results['students']->count() + $results['teachers']->count() + $results['classes']->count() === 0)
                <div class="bg-white rounded-lg shadow p-8 text-center text-gray-500">No results found for "{{ $query }}".</div>
            @endif
        @endif
    </div>
</x-app-layout>

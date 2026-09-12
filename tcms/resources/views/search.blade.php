<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">Search</h2>
    </x-slot>

    <div class="space-y-6">
        {{-- Search Input --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <form method="GET" class="flex flex-col sm:flex-row gap-4">
                <input type="text" name="q" value="{{ $query }}" placeholder="Search students, teachers, classes..."
                    autofocus
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none flex-1">
                <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-xl transition shadow-sm whitespace-nowrap">
                    Search
                </button>
            </form>
        </div>

        @if(strlen($query) >= 2)
            {{-- Students --}}
            @if($results['students']->count() > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-blue-50">
                        <h3 class="text-lg font-bold text-blue-900">Students <span class="text-sm font-medium text-blue-600">({{ $results['students']->count() }})</span></h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Classes</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($results['students'] as $student)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 text-sm">
                                            <a href="{{ route('students.show', $student) }}" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm">{{ $student->full_name }}</a>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $student->user->email ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            @foreach($student->classrooms as $c)
                                                <span class="inline-block bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full mr-1">{{ $c->name }}-{{ $c->section }}</span>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- Teachers --}}
            @if($results['teachers']->count() > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-emerald-50">
                        <h3 class="text-lg font-bold text-emerald-900">Teachers <span class="text-sm font-medium text-emerald-600">({{ $results['teachers']->count() }})</span></h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Specialization</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($results['teachers'] as $teacher)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 text-sm">
                                            <a href="{{ route('teachers.show', $teacher) }}" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm">{{ $teacher->full_name }}</a>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $teacher->specialization ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- Classes --}}
            @if($results['classes']->count() > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-amber-50">
                        <h3 class="text-lg font-bold text-amber-900">Classes <span class="text-sm font-medium text-amber-600">({{ $results['classes']->count() }})</span></h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Class</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Academic Year</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($results['classes'] as $class)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 text-sm">
                                            <a href="{{ route('classrooms.show', $class) }}" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm">{{ $class->name }}-{{ $class->section }}</a>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $class->academic_year }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- Empty State --}}
            @if($results['students']->count() + $results['teachers']->count() + $results['classes']->count() === 0)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="flex flex-col items-center">
                        <span class="text-4xl mb-3">🔍</span>
                        <p class="text-gray-500 font-medium">No results found for "{{ $query }}".</p>
                    </div>
                </div>
            @endif
        @endif
    </div>
</x-app-layout>

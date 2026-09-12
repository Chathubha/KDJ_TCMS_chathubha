<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="text-2xl font-bold text-gray-900">Student Profile</h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('students.edit', $student) }}" class="bg-white border-2 border-gray-200 text-gray-700 hover:bg-gray-50 font-semibold py-3 px-6 rounded-xl transition text-sm">Edit</a>
                <a href="{{ route('students.index') }}" class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-xl transition shadow-sm text-sm">Back to List</a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Student Info Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            {{-- Student Header --}}
            <div class="flex items-center gap-4 pb-6 border-b border-gray-100">
                <div class="w-16 h-16 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-2xl font-bold">
                    {{ substr($student->full_name, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $student->full_name }}</h3>
                    <p class="text-sm text-gray-500">{{ $student->user->email ?? '-' }}</p>
                </div>
            </div>

            {{-- Details Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pt-6">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Full Name</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $student->full_name }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Email</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $student->user->email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Date of Birth</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $student->dob?->format('M d, Y') ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Gender</p>
                    <p class="text-sm font-semibold text-gray-900 capitalize">{{ $student->gender }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Phone</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $student->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Address</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $student->address ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Enrolled Classes --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Enrolled Classes</h3>

            @if($student->classrooms->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($student->classrooms as $class)
                        <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm shrink-0">
                                {{ substr($class->name, 0, 2) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $class->name }}-{{ $class->section }}</p>
                                <p class="text-xs text-gray-500">{{ $class->pivot->academic_year }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 rounded-xl p-8 text-center">
                    <span class="text-3xl block mb-2">🏫</span>
                    <p class="text-gray-500 text-sm font-medium">No classes enrolled</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

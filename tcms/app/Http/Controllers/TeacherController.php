<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Subject;
use App\Services\TeacherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class TeacherController extends Controller
{
    public function __construct(
        private TeacherService $teacherService
    ) {}

    public function index(Request $request)
    {
        $teachers = $this->teacherService->getAll($request->only(['search']));
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        $subjects = Subject::orderBy('name')->get();
        return view('teachers.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'subject_ids' => 'nullable|array',
            'subject_ids.*' => 'exists:subjects,id',
        ]);

        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'email_verified_at' => now(),
        ]);

        $teacher = $this->teacherService->create(array_merge(
            $validated,
            ['user_id' => $user->id]
        ));

        if (!empty($validated['subject_ids'])) {
            $this->teacherService->syncSubjects($teacher, $validated['subject_ids']);
        }

        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully.');
    }

    public function show(Teacher $teacher)
    {
        $teacher->load(['user', 'subjects', 'schedules.classroom', 'schedules.subject']);
        return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        $subjects = Subject::orderBy('name')->get();
        $teacher->load('subjects');
        return view('teachers.edit', compact('teacher', 'subjects'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'subject_ids' => 'nullable|array',
            'subject_ids.*' => 'exists:subjects,id',
        ]);

        $this->teacherService->update($teacher, $validated);

        if (isset($validated['subject_ids'])) {
            $this->teacherService->syncSubjects($teacher, $validated['subject_ids']);
        }

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        $this->teacherService->delete($teacher);
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}

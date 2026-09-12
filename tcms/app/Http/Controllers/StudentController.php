<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classroom;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class StudentController extends Controller
{
    public function __construct(
        private StudentService $studentService
    ) {}

    public function index(Request $request)
    {
        $students = $this->studentService->getAll($request->only(['search', 'classroom_id']));
        $classrooms = Classroom::orderBy('name')->get();

        return view('students.index', compact('students', 'classrooms'));
    }

    public function create()
    {
        $classrooms = Classroom::orderBy('name')->get();
        return view('students.create', compact('classrooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'dob' => 'nullable|date',
            'gender' => 'required|in:male,female,other',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'classroom_id' => 'nullable|exists:classrooms,id',
        ]);

        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make('password'),
            'role' => 'student',
            'email_verified_at' => now(),
        ]);

        $student = $this->studentService->create(array_merge(
            $validated,
            ['user_id' => $user->id]
        ));

        if (!empty($validated['classroom_id'])) {
            $this->studentService->enroll($student, $validated['classroom_id'], date('Y') . '-' . (date('Y') + 1));
        }

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        $student->load(['user', 'classrooms', 'attendances', 'grades.exam']);
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $classrooms = Classroom::orderBy('name')->get();
        $student->load('classrooms');
        return view('students.edit', compact('student', 'classrooms'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'dob' => 'nullable|date',
            'gender' => 'required|in:male,female,other',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'classroom_id' => 'nullable|exists:classrooms,id',
        ]);

        $this->studentService->update($student, $validated);

        if (!empty($validated['classroom_id'])) {
            $this->studentService->enroll($student, $validated['classroom_id'], date('Y') . '-' . (date('Y') + 1));
        }

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $this->studentService->delete($student);
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}

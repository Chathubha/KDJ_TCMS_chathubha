<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Teacher;
use App\Services\ClassroomService;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function __construct(
        private ClassroomService $classroomService
    ) {}

    public function index(Request $request)
    {
        $classrooms = $this->classroomService->getAll($request->only(['search', 'academic_year']));
        return view('classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        $teachers = Teacher::orderBy('first_name')->get();
        return view('classrooms.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'section' => 'required|string|max:10',
            'capacity' => 'required|integer|min:1|max:100',
            'academic_year' => 'required|string|max:10',
            'class_teacher_id' => 'nullable|exists:teachers,id',
        ]);

        $this->classroomService->create($validated);

        return redirect()->route('classrooms.index')->with('success', 'Class created successfully.');
    }

    public function show(Classroom $classroom)
    {
        $classroom->load(['students.user', 'classTeacher', 'subjects']);
        $studentCount = $this->classroomService->getStudentCount($classroom);

        return view('classrooms.show', compact('classroom', 'studentCount'));
    }

    public function edit(Classroom $classroom)
    {
        $teachers = Teacher::orderBy('first_name')->get();
        return view('classrooms.edit', compact('classroom', 'teachers'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'section' => 'required|string|max:10',
            'capacity' => 'required|integer|min:1|max:100',
            'academic_year' => 'required|string|max:10',
            'class_teacher_id' => 'nullable|exists:teachers,id',
        ]);

        $this->classroomService->update($classroom, $validated);

        return redirect()->route('classrooms.index')->with('success', 'Class updated successfully.');
    }

    public function destroy(Classroom $classroom)
    {
        $this->classroomService->delete($classroom);
        return redirect()->route('classrooms.index')->with('success', 'Class deleted successfully.');
    }
}

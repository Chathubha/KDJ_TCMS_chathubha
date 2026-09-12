<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Classroom;
use App\Models\Teacher;
use App\Services\SubjectService;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function __construct(
        private SubjectService $subjectService
    ) {}

    public function index(Request $request)
    {
        $subjects = $this->subjectService->getAll($request->only(['search', 'classroom_id']));
        $classrooms = Classroom::orderBy('name')->get();

        return view('subjects.index', compact('subjects', 'classrooms'));
    }

    public function create()
    {
        $classrooms = Classroom::orderBy('name')->get();
        $teachers = Teacher::orderBy('first_name')->get();
        return view('subjects.create', compact('classrooms', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:subjects,code',
            'description' => 'nullable|string',
            'classroom_id' => 'required|exists:classrooms,id',
            'teacher_ids' => 'nullable|array',
            'teacher_ids.*' => 'exists:teachers,id',
        ]);

        $teacherIds = $validated['teacher_ids'] ?? [];
        unset($validated['teacher_ids']);

        $subject = $this->subjectService->create($validated);

        if (!empty($teacherIds)) {
            $this->subjectService->syncTeachers($subject, $teacherIds);
        }

        return redirect()->route('subjects.index')->with('success', 'Subject created successfully.');
    }

    public function show(Subject $subject)
    {
        $subject->load(['classroom', 'teachers', 'exams']);
        return view('subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        $classrooms = Classroom::orderBy('name')->get();
        $teachers = Teacher::orderBy('first_name')->get();
        $subject->load('teachers');
        return view('subjects.edit', compact('subject', 'classrooms', 'teachers'));
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:subjects,code,' . $subject->id,
            'description' => 'nullable|string',
            'classroom_id' => 'required|exists:classrooms,id',
            'teacher_ids' => 'nullable|array',
            'teacher_ids.*' => 'exists:teachers,id',
        ]);

        $teacherIds = $validated['teacher_ids'] ?? [];
        unset($validated['teacher_ids']);

        $this->subjectService->update($subject, $validated);
        $this->subjectService->syncTeachers($subject, $teacherIds);

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $this->subjectService->delete($subject);
        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }
}

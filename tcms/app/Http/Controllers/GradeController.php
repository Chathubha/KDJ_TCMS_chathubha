<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Subject;
use App\Models\Classroom;
use App\Services\GradeService;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function __construct(
        private GradeService $gradeService
    ) {}

    public function index(Request $request)
    {
        $exams = $this->gradeService->getAllExams($request->only(['classroom_id', 'subject_id']));
        $classrooms = Classroom::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();

        return view('grades.index', compact('exams', 'classrooms', 'subjects'));
    }

    public function create()
    {
        $classrooms = Classroom::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        return view('grades.create', compact('classrooms', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'subject_id' => 'required|exists:subjects,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'date' => 'nullable|date',
            'max_marks' => 'required|integer|min:1',
            'weight' => 'required|integer|min:1',
        ]);

        $this->gradeService->createExam($validated);

        return redirect()->route('grades.index')->with('success', 'Exam created successfully.');
    }

    public function show($id)
    {
        $exam = $this->gradeService->getExamById($id);
        $exam->load(['subject', 'classroom', 'grades.student']);
        return view('grades.show', compact('exam'));
    }

    public function edit($id)
    {
        $exam = $this->gradeService->getExamById($id);
        $classrooms = Classroom::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        return view('grades.edit', compact('exam', 'classrooms', 'subjects'));
    }

    public function update(Request $request, $id)
    {
        $exam = $this->gradeService->getExamById($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'subject_id' => 'required|exists:subjects,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'date' => 'nullable|date',
            'max_marks' => 'required|integer|min:1',
            'weight' => 'required|integer|min:1',
        ]);

        $this->gradeService->updateExam($exam, $validated);

        return redirect()->route('grades.index')->with('success', 'Exam updated successfully.');
    }

    public function destroy($id)
    {
        $exam = $this->gradeService->getExamById($id);
        $this->gradeService->deleteExam($exam);
        return redirect()->route('grades.index')->with('success', 'Exam deleted successfully.');
    }

    public function entry($id)
    {
        $data = $this->gradeService->getStudentsForGrading($id);
        return view('grades.entry', $data);
    }

    public function storeGrades(Request $request, $id)
    {
        $exam = $this->gradeService->getExamById($id);

        $validated = $request->validate([
            'grades' => 'required|array',
            'grades.*.marks_obtained' => 'nullable|numeric|min:0|max:' . $exam->max_marks,
            'grades.*.remarks' => 'nullable|string|max:255',
        ]);

        $this->gradeService->storeGrades($id, $validated['grades']);

        return redirect()->route('grades.show', $id)->with('success', 'Grades saved successfully.');
    }

    public function reportCard(int $studentId)
    {
        $data = $this->gradeService->getReportCard($studentId);
        return view('grades.report-card', $data);
    }
}

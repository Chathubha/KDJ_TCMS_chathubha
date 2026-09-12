<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GradeService
{
    public function getAllExams(array $filters = []): LengthAwarePaginator
    {
        $query = Exam::with(['subject', 'classroom']);

        if (!empty($filters['classroom_id'])) {
            $query->where('classroom_id', $filters['classroom_id']);
        }
        if (!empty($filters['subject_id'])) {
            $query->where('subject_id', $filters['subject_id']);
        }

        return $query->orderBy('date', 'desc')->paginate(15);
    }

    public function getExamById(int $id): Exam
    {
        return Exam::with(['subject', 'classroom'])->findOrFail($id);
    }

    public function createExam(array $data): Exam
    {
        return Exam::create($data);
    }

    public function updateExam(Exam $exam, array $data): Exam
    {
        $exam->update($data);
        return $exam;
    }

    public function deleteExam(Exam $exam): bool
    {
        return $exam->delete();
    }

    public function getStudentsForGrading(int $examId): array
    {
        $exam = Exam::with('classroom')->findOrFail($examId);
        $students = Student::whereHas('classrooms', fn($q) => $q->where('classrooms.id', $exam->classroom_id))
            ->with(['grades' => fn($q) => $q->where('exam_id', $examId)])
            ->orderBy('first_name')
            ->get();

        return ['exam' => $exam, 'students' => $students];
    }

    public function storeGrades(int $examId, array $gradesData): void
    {
        foreach ($gradesData as $studentId => $data) {
            Grade::updateOrCreate(
                ['student_id' => $studentId, 'exam_id' => $examId],
                [
                    'marks_obtained' => $data['marks_obtained'] ?? null,
                    'remarks' => $data['remarks'] ?? null,
                ]
            );
        }
    }

    public function getReportCard(int $studentId): array
    {
        $student = Student::with(['classrooms', 'grades.exam.subject', 'attendances'])->findOrFail($studentId);
        $classroom = $student->classrooms->first();

        $exams = Exam::where('classroom_id', $classroom?->id)
            ->with(['subject', 'grades' => fn($q) => $q->where('student_id', $studentId)])
            ->get();

        $totalMarks = 0;
        $totalMax = 0;
        $subjectGrades = [];

        foreach ($exams as $exam) {
            $grade = $exam->grades->first();
            $marks = $grade?->marks_obtained ?? 0;
            $totalMarks += $marks;
            $totalMax += $exam->max_marks;

            $subjectGrades[] = [
                'subject' => $exam->subject->name,
                'exam' => $exam->name,
                'marks' => $marks,
                'max_marks' => $exam->max_marks,
                'percentage' => $exam->max_marks > 0 ? round($marks / $exam->max_marks * 100, 1) : 0,
            ];
        }

        $overallPercentage = $totalMax > 0 ? round($totalMarks / $totalMax * 100, 1) : 0;

        return [
            'student' => $student,
            'classroom' => $classroom,
            'grades' => $subjectGrades,
            'totalMarks' => $totalMarks,
            'totalMax' => $totalMax,
            'overallPercentage' => $overallPercentage,
        ];
    }

    public function getClassSummary(int $classroomId): array
    {
        $students = Student::whereHas('classrooms', fn($q) => $q->where('classrooms.id', $classroomId))
            ->with(['grades.exam'])
            ->get();

        $summary = [];
        foreach ($students as $student) {
            $totalMarks = $student->grades->sum('marks_obtained');
            $totalMax = $student->grades->sum('exam.max_marks');
            $summary[] = [
                'student' => $student,
                'totalMarks' => $totalMarks,
                'totalMax' => $totalMax,
                'percentage' => $totalMax > 0 ? round($totalMarks / $totalMax * 100, 1) : 0,
            ];
        }

        usort($summary, fn($a, $b) => $b['percentage'] <=> $a['percentage']);
        return $summary;
    }
}

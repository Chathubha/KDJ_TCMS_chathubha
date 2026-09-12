<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Support\Collection;

class AttendanceService
{
    public function getStudentsForMarking(int $classroomId, string $date): Collection
    {
        return Student::whereHas('classrooms', fn($q) => $q->where('classrooms.id', $classroomId))
            ->with(['attendances' => fn($q) => $q->where('date', $date)])
            ->orderBy('first_name')
            ->get();
    }

    public function markBulk(array $attendances, int $classroomId, string $date, int $markedBy): void
    {
        foreach ($attendances as $studentId => $data) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'classroom_id' => $classroomId,
                    'subject_id' => $data['subject_id'] ?? null,
                    'date' => $date,
                ],
                [
                    'status' => $data['status'],
                    'marked_by' => $markedBy,
                    'remarks' => $data['remarks'] ?? null,
                ]
            );
        }
    }

    public function getHistory(array $filters = [])
    {
        $query = Attendance::with(['student', 'classroom', 'subject']);

        if (!empty($filters['classroom_id'])) {
            $query->where('classroom_id', $filters['classroom_id']);
        }
        if (!empty($filters['date_from'])) {
            $query->where('date', '>=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $query->where('date', '<=', $filters['date_to']);
        }

        return $query->orderBy('date', 'desc')->paginate(20);
    }

    public function getReport(int $classroomId): array
    {
        $students = Student::whereHas('classrooms', fn($q) => $q->where('classrooms.id', $classroomId))
            ->with(['attendances' => fn($q) => $q->where('classroom_id', $classroomId)])
            ->get();

        $totalDays = Attendance::where('classroom_id', $classroomId)
            ->distinct('date')
            ->count('date');

        $report = [];
        foreach ($students as $student) {
            $present = $student->attendances->where('status', 'present')->count();
            $late = $student->attendances->where('status', 'late')->count();
            $absent = $student->attendances->where('status', 'absent')->count();
            $total = $present + $late + $absent;
            $percentage = $total > 0 ? round(($present + $late) / $total * 100, 1) : 0;

            $report[] = [
                'student' => $student,
                'present' => $present,
                'late' => $late,
                'absent' => $absent,
                'total' => $total,
                'percentage' => $percentage,
            ];
        }

        return ['report' => $report, 'totalDays' => $totalDays];
    }
}

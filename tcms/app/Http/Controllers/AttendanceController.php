<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Attendance;
use App\Services\AttendanceService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function __construct(
        private AttendanceService $attendanceService
    ) {}

    public function index(Request $request)
    {
        $attendances = $this->attendanceService->getHistory($request->only(['classroom_id', 'date_from', 'date_to']));
        $classrooms = Classroom::orderBy('name')->get();

        return view('attendance.index', compact('attendances', 'classrooms'));
    }

    public function mark(Request $request)
    {
        $classroomId = $request->input('classroom_id');
        $date = $request->input('date', date('Y-m-d'));
        $students = collect();
        $subjects = collect();
        $classrooms = Classroom::orderBy('name')->get();

        if ($classroomId) {
            $students = $this->attendanceService->getStudentsForMarking($classroomId, $date);
            $subjects = Subject::where('classroom_id', $classroomId)->orderBy('name')->get();
        }

        return view('attendance.mark', compact('students', 'classrooms', 'subjects', 'classroomId', 'date'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.status' => 'required|in:present,absent,late,excused',
            'attendances.*.subject_id' => 'nullable|exists:subjects,id',
            'attendances.*.remarks' => 'nullable|string|max:255',
        ]);

        $this->attendanceService->markBulk(
            $validated['attendances'],
            $validated['classroom_id'],
            $validated['date'],
            auth()->id()
        );

        return redirect()->route('attendance.mark', ['classroom_id' => $validated['classroom_id'], 'date' => $validated['date']])
            ->with('success', 'Attendance marked successfully.');
    }

    public function history(Request $request)
    {
        return $this->index($request);
    }

    public function report(Request $request)
    {
        $classroomId = $request->input('classroom_id');
        $classrooms = Classroom::orderBy('name')->get();
        $report = [];
        $totalDays = 0;

        if ($classroomId) {
            $result = $this->attendanceService->getReport($classroomId);
            $report = $result['report'];
            $totalDays = $result['totalDays'];
        }

        return view('attendance.report', compact('report', 'classrooms', 'classroomId', 'totalDays'));
    }

    public function export(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        $attendances = Attendance::with(['student', 'classroom'])
            ->where('classroom_id', $request->classroom_id)
            ->orderBy('date', 'desc')
            ->get();

        $csv = "Date,Student,Class,Status,Remarks\n";
        foreach ($attendances as $att) {
            $csv .= '"' . $att->date->format('Y-m-d') . '",';
            $csv .= '"' . ($att->student->full_name ?? '') . '",';
            $csv .= '"' . ($att->classroom->name ?? '') . '-' . ($att->classroom->section ?? '') . '",';
            $csv .= '"' . $att->status . '",';
            $csv .= '"' . ($att->remarks ?? '') . '"' . "\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="attendance_' . $request->classroom_id . '_' . date('Y-m-d') . '.csv"',
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Period;
use App\Services\ScheduleService;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function __construct(
        private ScheduleService $scheduleService
    ) {}

    public function index(Request $request)
    {
        $classroomId = $request->input('classroom_id');
        $timetable = null;
        $classrooms = Classroom::orderBy('name')->get();

        if ($classroomId) {
            $timetable = $this->scheduleService->getTimetable($classroomId);
        }

        return view('schedule.index', compact('timetable', 'classrooms', 'classroomId'));
    }

    public function create()
    {
        $classrooms = Classroom::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $teachers = Teacher::orderBy('first_name')->get();
        $periods = Period::orderBy('order')->get();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

        return view('schedule.create', compact('classrooms', 'subjects', 'teachers', 'periods', 'days'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'period_id' => 'required|exists:periods,id',
            'day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday',
        ]);

        if ($this->scheduleService->checkConflict($validated['teacher_id'], $validated['period_id'], $validated['day'])) {
            return back()->withErrors(['teacher_id' => 'Teacher is already assigned to this period on this day.'])->withInput();
        }

        $this->scheduleService->create($validated);

        return redirect()->route('schedule.index', ['classroom_id' => $validated['classroom_id']])
            ->with('success', 'Schedule created successfully.');
    }

    public function edit(Schedule $schedule)
    {
        $classrooms = Classroom::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $teachers = Teacher::orderBy('first_name')->get();
        $periods = Period::orderBy('order')->get();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

        return view('schedule.edit', compact('schedule', 'classrooms', 'subjects', 'teachers', 'periods', 'days'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'period_id' => 'required|exists:periods,id',
            'day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday',
        ]);

        if ($this->scheduleService->checkConflict($validated['teacher_id'], $validated['period_id'], $validated['day'], $schedule->id)) {
            return back()->withErrors(['teacher_id' => 'Teacher is already assigned to this period on this day.'])->withInput();
        }

        $this->scheduleService->update($schedule, $validated);

        return redirect()->route('schedule.index', ['classroom_id' => $validated['classroom_id']])
            ->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $classroomId = $schedule->classroom_id;
        $this->scheduleService->delete($schedule);

        return redirect()->route('schedule.index', ['classroom_id' => $classroomId])
            ->with('success', 'Schedule deleted successfully.');
    }
}

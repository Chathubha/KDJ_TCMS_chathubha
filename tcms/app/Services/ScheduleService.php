<?php

namespace App\Services;

use App\Models\Schedule;
use App\Models\Period;
use Illuminate\Support\Collection;

class ScheduleService
{
    public function getTimetable(int $classroomId): array
    {
        $periods = Period::orderBy('order')->get();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

        $schedules = Schedule::where('classroom_id', $classroomId)
            ->with(['subject', 'teacher', 'period'])
            ->get()
            ->keyBy(fn($s) => $s->day . '_' . $s->period_id);

        $timetable = [];
        foreach ($days as $day) {
            $timetable[$day] = [];
            foreach ($periods as $period) {
                $timetable[$day][$period->id] = $schedules->get($day . '_' . $period->id);
            }
        }

        return ['periods' => $periods, 'days' => $days, 'timetable' => $timetable];
    }

    public function getTeacherTimetable(int $teacherId): array
    {
        $periods = Period::orderBy('order')->get();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

        $schedules = Schedule::where('teacher_id', $teacherId)
            ->with(['subject', 'classroom', 'period'])
            ->get()
            ->keyBy(fn($s) => $s->day . '_' . $s->period_id);

        $timetable = [];
        foreach ($days as $day) {
            $timetable[$day] = [];
            foreach ($periods as $period) {
                $timetable[$day][$period->id] = $schedules->get($day . '_' . $period->period_id ?? $day . '_' . $period->id);
            }
        }

        return ['periods' => $periods, 'days' => $days, 'timetable' => $timetable];
    }

    public function checkConflict(int $teacherId, int $periodId, string $day, ?int $excludeId = null): bool
    {
        $query = Schedule::where('teacher_id', $teacherId)
            ->where('period_id', $periodId)
            ->where('day', $day);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    public function create(array $data): Schedule
    {
        return Schedule::create($data);
    }

    public function update(Schedule $schedule, array $data): Schedule
    {
        $schedule->update($data);
        return $schedule;
    }

    public function delete(Schedule $schedule): bool
    {
        return $schedule->delete();
    }

    public function getAll(): Collection
    {
        return Schedule::with(['classroom', 'subject', 'teacher', 'period'])->orderBy('day')->orderBy('period_id')->get();
    }
}

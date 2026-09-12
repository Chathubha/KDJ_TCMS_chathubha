<?php

namespace Database\Seeders;

use App\Models\Period;
use App\Models\Schedule;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $periods = [
            ['name' => 'Period 1', 'start_time' => '08:00', 'end_time' => '08:45', 'order' => 1],
            ['name' => 'Period 2', 'start_time' => '08:45', 'end_time' => '09:30', 'order' => 2],
            ['name' => 'Period 3', 'start_time' => '09:45', 'end_time' => '10:30', 'order' => 3],
            ['name' => 'Period 4', 'start_time' => '10:30', 'end_time' => '11:15', 'order' => 4],
            ['name' => 'Lunch Break', 'start_time' => '11:15', 'end_time' => '12:00', 'order' => 5],
            ['name' => 'Period 5', 'start_time' => '12:00', 'end_time' => '12:45', 'order' => 6],
            ['name' => 'Period 6', 'start_time' => '12:45', 'end_time' => '13:30', 'order' => 7],
        ];

        foreach ($periods as $p) {
            Period::create($p);
        }

        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
        $classrooms = Classroom::all();
        $teachers = Teacher::all();
        $periodObjects = Period::whereIn('order', [1, 2, 3, 4])->get();

        $usedSlots = []; // track teacher_id+period+day

        foreach ($classrooms as $class) {
            $subjects = Subject::where('classroom_id', $class->id)->get();
            if ($subjects->isEmpty()) continue;

            $subjectIndex = 0;

            foreach ($days as $day) {
                foreach ($periodObjects as $period) {
                    $subject = $subjects[$subjectIndex % $subjects->count()];
                    $subjectIndex++;

                    // Find a teacher that has this subject and isn't booked at this slot
                    $assigned = false;
                    foreach ($teachers as $teacher) {
                        if (!$teacher->subjects->contains($subject->id)) continue;

                        $slotKey = $teacher->id . '_' . $period->id . '_' . $day;
                        if (isset($usedSlots[$slotKey])) continue;

                        Schedule::create([
                            'classroom_id' => $class->id,
                            'subject_id' => $subject->id,
                            'teacher_id' => $teacher->id,
                            'period_id' => $period->id,
                            'day' => $day,
                        ]);

                        $usedSlots[$slotKey] = true;
                        $assigned = true;
                        break;
                    }

                    // If no matching teacher found, use any free teacher
                    if (!$assigned) {
                        foreach ($teachers as $teacher) {
                            $slotKey = $teacher->id . '_' . $period->id . '_' . $day;
                            if (isset($usedSlots[$slotKey])) continue;

                            Schedule::create([
                                'classroom_id' => $class->id,
                                'subject_id' => $subject->id,
                                'teacher_id' => $teacher->id,
                                'period_id' => $period->id,
                                'day' => $day,
                            ]);

                            $usedSlots[$slotKey] = true;
                            break;
                        }
                    }
                }
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = User::where('role', 'admin')->first()->id;
        $statuses = ['present', 'present', 'present', 'present', 'absent', 'late', 'present', 'excused'];

        // Create 10 days of attendance for each class
        for ($day = 0; $day < 10; $day++) {
            $date = now()->subDays($day + 1)->format('Y-m-d');

            $classrooms = Classroom::all();
            foreach ($classrooms as $class) {
                $students = $class->students;
                foreach ($students as $student) {
                    Attendance::create([
                        'student_id' => $student->id,
                        'classroom_id' => $class->id,
                        'subject_id' => null,
                        'date' => $date,
                        'status' => $statuses[array_rand($statuses)],
                        'marked_by' => $adminId,
                    ]);
                }
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Classroom;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    public function run(): void
    {
        $exams = [
            ['name' => 'Midterm', 'max_marks' => 50, 'weight' => 30],
            ['name' => 'Final', 'max_marks' => 100, 'weight' => 50],
        ];

        $classrooms = Classroom::all();

        foreach ($classrooms as $class) {
            $subjects = Subject::where('classroom_id', $class->id)->take(3)->get();
            foreach ($subjects as $subject) {
                foreach ($exams as $examData) {
                    $exam = Exam::create([
                        'name' => $examData['name'] . ' - ' . $subject->name,
                        'subject_id' => $subject->id,
                        'classroom_id' => $class->id,
                        'date' => now()->subDays(rand(5, 60)),
                        'max_marks' => $examData['max_marks'],
                        'weight' => $examData['weight'],
                    ]);

                    $students = $class->students;
                    foreach ($students as $student) {
                        Grade::create([
                            'student_id' => $student->id,
                            'exam_id' => $exam->id,
                            'marks_obtained' => rand(intval($examData['max_marks'] * 0.3), $examData['max_marks']),
                        ]);
                    }
                }
            }
        }
    }
}

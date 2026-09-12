<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\Classroom;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            ['name' => 'Mathematics', 'code' => 'MATH'],
            ['name' => 'English', 'code' => 'ENG'],
            ['name' => 'Science', 'code' => 'SCI'],
            ['name' => 'Hindi', 'code' => 'HIN'],
            ['name' => 'Social Science', 'code' => 'SST'],
            ['name' => 'Computer Science', 'code' => 'CS'],
        ];

        $classrooms = Classroom::all();

        foreach ($classrooms as $class) {
            foreach ($subjects as $subj) {
                Subject::create([
                    'name' => $subj['name'],
                    'code' => $subj['code'] . '-' . $class->name . $class->section,
                    'description' => $subj['name'] . ' for Class ' . $class->name . '-' . $class->section,
                    'classroom_id' => $class->id,
                ]);
            }
        }
    }
}

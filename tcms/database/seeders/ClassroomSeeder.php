<?php

namespace Database\Seeders;

use App\Models\Classroom;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [
            ['name' => '10', 'section' => 'A'],
            ['name' => '10', 'section' => 'B'],
            ['name' => '9',  'section' => 'A'],
            ['name' => '9',  'section' => 'B'],
            ['name' => '8',  'section' => 'A'],
            ['name' => '8',  'section' => 'B'],
            ['name' => '7',  'section' => 'A'],
            ['name' => '7',  'section' => 'B'],
        ];

        foreach ($classes as $class) {
            Classroom::create([
                'name' => $class['name'],
                'section' => $class['section'],
                'capacity' => 40,
                'academic_year' => '2026-2027',
            ]);
        }
    }
}

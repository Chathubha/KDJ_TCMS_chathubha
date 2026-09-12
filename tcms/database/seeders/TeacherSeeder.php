<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class TeacherSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    public function run(): void
    {
        $teachers = [
            ['first_name' => 'Rajesh', 'last_name' => 'Kumar', 'qualification' => 'M.Sc, B.Ed', 'specialization' => 'Mathematics'],
            ['first_name' => 'Priya', 'last_name' => 'Sharma', 'qualification' => 'M.A, B.Ed', 'specialization' => 'English'],
            ['first_name' => 'Anil', 'last_name' => 'Verma', 'qualification' => 'M.Sc', 'specialization' => 'Physics'],
            ['first_name' => 'Sunita', 'last_name' => 'Patel', 'qualification' => 'M.Sc, B.Ed', 'specialization' => 'Chemistry'],
            ['first_name' => 'Vikram', 'last_name' => 'Singh', 'qualification' => 'M.A', 'specialization' => 'History'],
            ['first_name' => 'Meena', 'last_name' => 'Gupta', 'qualification' => 'M.Sc', 'specialization' => 'Biology'],
            ['first_name' => 'Suresh', 'last_name' => 'Rao', 'qualification' => 'M.Sc, B.Ed', 'specialization' => 'Mathematics'],
            ['first_name' => 'Kavita', 'last_name' => 'Joshi', 'qualification' => 'M.A, B.Ed', 'specialization' => 'Hindi'],
            ['first_name' => 'Deepak', 'last_name' => 'Nair', 'qualification' => 'M.Sc', 'specialization' => 'Computer Science'],
            ['first_name' => 'Ritu', 'last_name' => 'Choudhary', 'qualification' => 'M.A, B.Ed', 'specialization' => 'Social Science'],
        ];

        $subjects = Subject::pluck('id')->toArray();

        foreach ($teachers as $i => $data) {
            $user = User::create([
                'name' => $data['first_name'] . ' ' . $data['last_name'],
                'email' => strtolower($data['first_name']) . ($i + 1) . '@teacher.tcms.com',
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'email_verified_at' => now(),
            ]);

            $teacher = Teacher::create([
                'user_id' => $user->id,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone' => '9' . rand(100000000, 999999999),
                'qualification' => $data['qualification'],
                'specialization' => $data['specialization'],
            ]);

            // Assign 2-3 random subjects
            if (!empty($subjects)) {
                $randomSubjects = collect($subjects)->random(min(3, count($subjects)))->toArray();
                $teacher->subjects()->attach($randomSubjects);
            }
        }
    }
}

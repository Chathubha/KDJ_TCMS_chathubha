<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }
    public function run(): void
    {
        $firstNames = ['Aarav','Vivaan','Aditya','Arjun','Sai','Rohan','Vihaan','Krishna','Ishaan','Reyansh','Ananya','Diya','Priya','Nisha','Kavya','Meera','Riya','Aisha','Pooja','Neha','Sneha','Rahul','Amit','Sanjay','Deepak','Raj','Vikram','Suresh','Manoj','Arun'];
        $lastNames = ['Sharma','Verma','Gupta','Singh','Kumar','Patel','Reddy','Nair','Joshi','Das','Mishra','Choudhary','Mehta','Kapoor','Sinha','Bhatt','Rao','Chauhan','Tiwari','Malhotra'];
        $classes = Classroom::pluck('id')->toArray();

        foreach ($firstNames as $i => $firstName) {
            $user = User::create([
                'name' => $firstName . ' ' . $lastNames[$i % count($lastNames)],
                'email' => strtolower($firstName) . ($i + 1) . '@student.tcms.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                'email_verified_at' => now(),
            ]);

            $student = Student::create([
                'user_id' => $user->id,
                'first_name' => $firstName,
                'last_name' => $lastNames[$i % count($lastNames)],
                'dob' => now()->subYears(rand(10, 16))->subDays(rand(0, 364)),
                'gender' => collect(['male', 'female'])->random(),
                'phone' => '9' . rand(100000000, 999999999),
                'address' => $this->faker->address(),
            ]);

            if (!empty($classes)) {
                $student->classrooms()->attach(
                    $classes[array_rand($classes)],
                    ['academic_year' => '2026-2027', 'enrolled_at' => now()]
                );
            }
        }
    }
}

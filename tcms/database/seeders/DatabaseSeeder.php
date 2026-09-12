<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create default admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@tcms.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create demo teacher user
        User::create([
            'name' => 'Teacher User',
            'email' => 'teacher@tcms.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'email_verified_at' => now(),
        ]);

        // Create demo student user
        User::create([
            'name' => 'Student User',
            'email' => 'student@tcms.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'email_verified_at' => now(),
        ]);

        // Seed in order
        $this->call(ClassroomSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(TeacherSeeder::class);
        $this->call(AttendanceSeeder::class);
        $this->call(GradeSeeder::class);
        $this->call(ScheduleSeeder::class);
    }
}

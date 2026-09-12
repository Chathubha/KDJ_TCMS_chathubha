<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StudentService
{
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = Student::with(['user', 'classrooms']);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['classroom_id'])) {
            $query->whereHas('classrooms', function ($q) use ($filters) {
                $q->where('classrooms.id', $filters['classroom_id']);
            });
        }

        return $query->orderBy('first_name')->paginate(15);
    }

    public function getById(int $id): Student
    {
        return Student::with(['user', 'classrooms'])->findOrFail($id);
    }

    public function create(array $data): Student
    {
        return Student::create($data);
    }

    public function update(Student $student, array $data): Student
    {
        $student->update($data);
        return $student;
    }

    public function delete(Student $student): bool
    {
        $user = $student->user;
        $student->delete();
        if ($user) {
            $user->delete();
        }
        return true;
    }

    public function enroll(Student $student, int $classroomId, string $academicYear): void
    {
        $student->classrooms()->attach($classroomId, [
            'academic_year' => $academicYear,
            'enrolled_at' => now(),
        ]);
    }

    public function unenroll(Student $student, int $classroomId, string $academicYear): void
    {
        $student->classrooms()->detach($classroomId);
    }
}

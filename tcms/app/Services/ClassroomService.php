<?php

namespace App\Services;

use App\Models\Classroom;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ClassroomService
{
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = Classroom::withCount('students');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('section', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['academic_year'])) {
            $query->where('academic_year', $filters['academic_year']);
        }

        return $query->orderBy('name')->orderBy('section')->paginate(15);
    }

    public function getById(int $id): Classroom
    {
        return Classroom::with(['students', 'classTeacher', 'subjects'])->findOrFail($id);
    }

    public function create(array $data): Classroom
    {
        return Classroom::create($data);
    }

    public function update(Classroom $classroom, array $data): Classroom
    {
        $classroom->update($data);
        return $classroom;
    }

    public function delete(Classroom $classroom): bool
    {
        return $classroom->delete();
    }

    public function isFull(Classroom $classroom): bool
    {
        return $classroom->students()->count() >= $classroom->capacity;
    }

    public function getStudentCount(Classroom $classroom): int
    {
        return $classroom->students()->count();
    }
}

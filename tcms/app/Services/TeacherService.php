<?php

namespace App\Services;

use App\Models\Teacher;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TeacherService
{
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = Teacher::with(['user', 'subjects']);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('first_name')->paginate(15);
    }

    public function getById(int $id): Teacher
    {
        return Teacher::with(['user', 'subjects'])->findOrFail($id);
    }

    public function create(array $data): Teacher
    {
        return Teacher::create($data);
    }

    public function update(Teacher $teacher, array $data): Teacher
    {
        $teacher->update($data);
        return $teacher;
    }

    public function delete(Teacher $teacher): bool
    {
        $user = $teacher->user;
        $teacher->delete();
        if ($user) {
            $user->delete();
        }
        return true;
    }

    public function syncSubjects(Teacher $teacher, array $subjectIds): void
    {
        $teacher->subjects()->sync($subjectIds);
    }
}

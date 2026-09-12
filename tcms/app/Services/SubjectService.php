<?php

namespace App\Services;

use App\Models\Subject;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SubjectService
{
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = Subject::with(['classroom', 'teachers']);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['classroom_id'])) {
            $query->where('classroom_id', $filters['classroom_id']);
        }

        return $query->orderBy('name')->paginate(15);
    }

    public function getById(int $id): Subject
    {
        return Subject::with(['classroom', 'teachers'])->findOrFail($id);
    }

    public function create(array $data): Subject
    {
        return Subject::create($data);
    }

    public function update(Subject $subject, array $data): Subject
    {
        $subject->update($data);
        return $subject;
    }

    public function delete(Subject $subject): bool
    {
        return $subject->delete();
    }

    public function syncTeachers(Subject $subject, array $teacherIds): void
    {
        $subject->teachers()->sync($teacherIds);
    }
}

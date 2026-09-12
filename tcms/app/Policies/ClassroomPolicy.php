<?php

namespace App\Policies;

use App\Models\Classroom;
use App\Models\User;

class ClassroomPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'teacher']);
    }

    public function view(User $user, Classroom $classroom): bool
    {
        return in_array($user->role, ['admin', 'teacher']);
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Classroom $classroom): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Classroom $classroom): bool
    {
        return $user->role === 'admin';
    }
}

<?php

namespace App\Policies;

use App\Models\Teacher;
use App\Models\User;

class TeacherPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'teacher']);
    }

    public function view(User $user, Teacher $teacher): bool
    {
        if ($user->role === 'admin') return true;
        if ($user->role === 'teacher') return true;
        return false;
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Teacher $teacher): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Teacher $teacher): bool
    {
        return $user->role === 'admin';
    }
}

<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;

class StudentPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'teacher']);
    }

    public function view(User $user, Student $student): bool
    {
        if ($user->role === 'admin') return true;
        if ($user->role === 'teacher') return true;
        if ($user->role === 'student') return $student->user_id === $user->id;
        return false;
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Student $student): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Student $student): bool
    {
        return $user->role === 'admin';
    }
}

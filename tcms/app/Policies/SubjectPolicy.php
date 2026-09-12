<?php

namespace App\Policies;

use App\Models\Subject;
use App\Models\User;

class SubjectPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'teacher']);
    }

    public function view(User $user, Subject $subject): bool
    {
        return in_array($user->role, ['admin', 'teacher']);
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Subject $subject): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Subject $subject): bool
    {
        return $user->role === 'admin';
    }
}

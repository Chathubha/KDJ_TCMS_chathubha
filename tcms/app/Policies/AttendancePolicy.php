<?php

namespace App\Policies;

use App\Models\User;

class AttendancePolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'teacher']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'teacher']);
    }
}

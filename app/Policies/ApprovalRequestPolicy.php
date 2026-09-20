<?php

namespace App\Policies;

use App\Models\ApprovalRequest;
use App\Models\User;

class ApprovalRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'manajer']);
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function decide(User $user, ApprovalRequest $req): bool
    {
        return $user->role === 'manajer' && $req->isPending();
    }

    public function riwayat(User $user): bool
    {
        return $user->role === 'manajer';
    }
}

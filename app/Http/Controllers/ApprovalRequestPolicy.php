<?php

namespace App\Policies;

use App\Models\ApprovalRequest;
use App\Models\User;

class ApprovalRequestPolicy
{
    // Siapa yang boleh lihat list?
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'manajer']);
    }

    // Siapa yang boleh buat pengajuan?
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    // Siapa yang boleh approve/reject?
    public function decide(User $user, ApprovalRequest $req): bool
    {
        return $user->role === 'manajer' && $req->isPending();
    }

    // Siapa yang boleh lihat riwayat?
    public function riwayat(User $user): bool
    {
        return $user->role === 'manajer';
    }
}

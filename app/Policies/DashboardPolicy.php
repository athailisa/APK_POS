<?php

namespace App\Policies;

use App\Models\User;

class DashboardPolicy
{
    /**
     * Tentukan siapa saja yang boleh melihat dashboard utama.
     */
    public function viewAny(User $user): bool
    {
        // Jika kasir (role_id = 2) yang masuk, baris ini otomatis menghasilkan FALSE (ditolak/disembunyikan)
        return (int) $user->role_id === 1;
    }
}

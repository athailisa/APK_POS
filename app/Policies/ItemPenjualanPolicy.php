<?php

namespace App\Policies;

use App\Models\ItemPenjualan;
use App\Models\User;

class ItemPenjualanPolicy
{
    /**
     * Create a new policy instance.
     */
    public function delete(User $user, ItemPenjualan $itempenjualan): bool
    {
        return $user->role->name === 'admin';
    }

    public function update(User $user, ItemPenjualan $itempenjualan): bool
    {
        return $itempenjualan->penjualan->status === 'OPEN'
            && ($itempenjualan->penjualan->user_id === $user->id || $user->role->name === 'admin');
    }
}

<?php

namespace App\Policies;

use App\Constants\RolesEnum;
use App\Models\Seller;
use App\Models\User;

class SellerPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(RolesEnum::OWNER->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Seller $seller): bool
    {
        return ($user->id === $seller->shop_id);
    }
}

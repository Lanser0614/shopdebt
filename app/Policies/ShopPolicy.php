<?php

namespace App\Policies;

use App\Constants\RolesEnum;
use App\Models\Shop;
use App\Models\User;

class ShopPolicy
{

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return !$user->hasRole(RolesEnum::SELLER->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Shop $shop): bool
    {
        return $user->hasRole(RolesEnum::OWNER->value) && $user->id === $shop->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */

    public function delete(User $user, Shop $shop): bool
    {
        return $user->hasRole(RolesEnum::OWNER->value) && $user->id === $shop->user_id;
    }

    public function shop_sellers(User $user, Shop $shop): bool
    {
        return $user->hasRole(RolesEnum::OWNER->value) && $user->id === $shop->user_id;
    }

    public function shop_clients(User $user, Shop $shop): bool
    {
        return $user->checkShopId($shop->id);
    }
}

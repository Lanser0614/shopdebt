<?php

namespace App\Policies;

use App\Constants\RolesEnum;
use App\Models\Shop;
use App\Models\User;

class ShopPolicy
{
    public function view(User $user, Shop $shop): bool
    {
        return $user->hasAnyRole(RolesEnum::OWNER->value,RolesEnum::SELLER->value) && $user->checkShopId($shop->id);
    }

    public function create(User $user): bool
    {
        return !$user->hasRole(RolesEnum::SELLER->value);
    }

    public function update(User $user, Shop $shop): bool
    {
        return $user->hasRole(RolesEnum::OWNER->value) && $user->id === $shop->user_id;
    }

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

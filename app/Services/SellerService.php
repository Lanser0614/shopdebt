<?php

namespace App\Services;

use App\Constants\RolesEnum;
use App\Models\Seller;

class SellerService {

    public function store($validated)
    {
        $code = $this->randomCode();
        $data = [
            'shop_id' => $validated['shop_id'],
            'label' => $validated['label'],
            'activation_code' => $code
        ];

        return Seller::query()->create($data);
    }

    /**
     * @throws \Exception
     */
    public function update($validated)
    {
        $seller = Seller::query()->where('activation_code', $validated['activation_code'])->first();
        if (!($seller->activation_code === $validated['activation_code']) && ($seller->is_activated === false)){
            throw new \Exception('Activation code invalid');
        }
        $seller->update([
            'user_id' => auth()->id(),
            'is_activated' => true
        ]);
        auth()->user()->syncRoles(RolesEnum::SELLER->value);

        return $seller;
    }

    protected function randomCode(): int
    {
        $code = random_int(10000000, 99999999);
        $check = Seller::query()->where('activation_code', $code)->first();
        if($check)
        {
            $this->randomCode();
        }
        return $code;
    }
}

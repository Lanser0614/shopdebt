<?php

namespace App\Services;

use App\Models\Debt;

class DebtService{

    /**
     * @throws \Exception
     */
    public function store($validated)
    {
        $validated['user_id'] = auth()->id();
        if (!auth()->user()->checkShopId($validated['shop_id'])){
            throw new \Exception('Can\'t create');
        }
         $debt = Debt::query()->create($validated);

        if (key_exists('products', $validated)){
            foreach ($validated['products'] as $product){
                if(!$product === $debt->shop_id){
                    throw new \Exception('Product shop id is invalid');
                }
            }
                $debt->products()->attach($validated['products']);
        }
        return $debt;
    }

    /**
     * @throws \Exception
     */
    public function update(Debt $debt, $validated): Debt
    {
        $debt->update($validated);
        if (key_exists('products', $validated)) {
            foreach ($validated['products'] as $product) {
                if (!$product === $debt->shop_id) {
                    throw new \Exception('Product shop id is invalid');
                }
            }
        $debt->products()->sync($validated['products']);
        }

        return $debt;
    }
}

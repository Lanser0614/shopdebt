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
        $debt->products()->attach($validated['products']);
        return $debt;
    }

    public function update(Debt $debt, $validated)
    {
        $debt->update($validated);

        $debt->products()->sync($validated['products']);

        return $debt;
    }
}

<?php

namespace App\Http\Controllers;

use App\Constants\ResponseConstants\DebtResponseEnum;
use App\Http\Requests\CreateDebtRequest;
use App\Http\Requests\UpdateDebtRequest;
use App\Http\Resources\DebtResource;
use App\Models\Debt;

class DebtController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Debt::class, 'debt');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateDebtRequest $request)
    {
        return $this->execute(function () use ($request){
            $validated = $request->validated();
            $validated['user_id'] = auth()->id();
            if (!auth()->user()->checkShopId($validated['shop_id'])){
                throw new \Exception('Can\'t create');
            }
            $debt = Debt::query()->create($validated);
            return DebtResource::make($debt->load('user', 'shop', 'client'));
        }, DebtResponseEnum::DEBT_CREATE);
    }

    /**
     * Display the specified resource.
     */
    public function show(Debt $debt)
    {
        return $this->execute(function () use ($debt){
            return DebtResource::make($debt->load('user', 'shop', 'client'));
        }, DebtResponseEnum::DEBT_SHOW);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDebtRequest $request, Debt $debt)
    {
        return $this->execute(function () use ($request, $debt){
            $validated = $request->validated();
            $debt->update($validated);
            return DebtResource::make($debt->load('user', 'shop', 'client'));
        }, DebtResponseEnum::DEBT_UPDATE);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Debt $debt)
    {
        return $this->execute(function () use ($debt){
            if (!$debt->delete()){
                throw new \Exception('Can\'t delete');
            }
        }, DebtResponseEnum::DEBT_DELETE);
    }
}

<?php

namespace App\Http\Controllers;

use App\Constants\ResponseConstants\DebtResponseEnum;
use App\Http\Requests\CreateDebtRequest;
use App\Http\Requests\UpdateDebtRequest;
use App\Http\Resources\DebtResource;
use App\Models\Debt;
use App\Services\DebtService;

class DebtController extends Controller
{
    public function __construct(protected DebtService $debtService)
    {
        $this->authorizeResource(Debt::class, 'debt');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateDebtRequest $request)
    {
        return $this->execute(function () use ($request){
            $debt = $this->debtService->store($request->validated());
            return DebtResource::make($debt->load('user', 'shop', 'client', 'products'));
        }, DebtResponseEnum::DEBT_CREATE);
    }

    /**
     * Display the specified resource.
     */
    public function show(Debt $debt)
    {
        return $this->execute(function () use ($debt){
            return DebtResource::make($debt->load('user', 'shop', 'client',  'products'));
        }, DebtResponseEnum::DEBT_SHOW);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDebtRequest $request, Debt $debt)
    {
        return $this->execute(function () use ($request, $debt){
            $debt = $this->debtService->update($debt, $request->validated());
            return DebtResource::make($debt->load('user', 'shop', 'client', 'products'));
        }, DebtResponseEnum::DEBT_UPDATE);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Debt $debt)
    {
        return $this->execute(function () use ($debt){
            $debt->products()->detach();
            if (!$debt->delete()){
                throw new \Exception('Can\'t delete');
            }
        }, DebtResponseEnum::DEBT_DELETE);
    }
}

<?php

namespace App\Http\Controllers;

use App\Constants\ResponseConstants\SellerResponseEnum;
use App\Http\Requests\Seller\CreateSellerRequest;
use App\Http\Requests\Seller\UpdateSellerRequest;
use App\Http\Resources\Seller\SellerCreateResource;
use App\Http\Resources\Seller\UpdateSellerResource;
use App\Models\Seller;
use App\Services\SellerService;

class SellerController extends Controller
{
    public function __construct(protected SellerService $sellerService)
    {
        $this->authorizeResource(Seller::class, 'seller');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSellerRequest $request)
    {
        return $this->execute(function () use ($request){
            $seller = $this->sellerService->store($request->validated());
            return SellerCreateResource::make($seller);
        }, SellerResponseEnum::SELLER_CREATE);
    }
    public function show(Seller $seller)
    {
        return $this->execute(function () use ($seller){
           return  UpdateSellerResource::make($seller);
        }, SellerResponseEnum::SELLER_SHOW);
    }
    /**
     * Update the specified resource in storage.
     */
    public function activate(UpdateSellerRequest $request)
    {
        return $this->execute(function () use ($request){
            $seller = $this->sellerService->update($request->validated());
            return UpdateSellerResource::make($seller->load('user', 'shop'));
        }, SellerResponseEnum::SELLER_UPDATED);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seller $seller)
    {
        return $this->execute(function () use ($seller){
            $this->sellerService->delete($seller);
        }, SellerResponseEnum::SELLER_DELETED);
    }

}

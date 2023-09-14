<?php

namespace App\Http\Controllers;

use App\Constants\ResponseConstants\ShopResponseEnum;
use App\Constants\RolesEnum;
use App\Http\Requests\ShopRequest;
use App\Http\Resources\Seller\UpdateSellerResource;
use App\Http\Resources\Shop\ShopResource;
use App\Models\Seller;
use App\Models\Shop;

class ShopController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(ShopRequest $request)
    {
        return $this->execute(function () use ($request){
            $validated = $request->validated();
            $validated['user_id'] = auth()->id();
            $shop = Shop::query()->create($validated);
            return ShopResource::make($shop->load('user'));
        }, ShopResponseEnum::SHOP_CREATE);
    }

    /**
     * Display the specified resource.
     */
    public function show(Shop $shop)
    {
        return $this->execute(function () use ($shop){
            return ShopResource::make($shop->load('user'));
        }, ShopResponseEnum::SHOP_INFO);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShopRequest $request, Shop $shop)
    {
        return $this->execute(function () use ($request, $shop){
            $validated = $request->validated();
            $validated['user_id'] = auth()->id();
            $shop->update($validated);
            return ShopResource::make($shop->load('user'));
        }, ShopResponseEnum::SHOP_UPDATE);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop)
    {
        return $this->execute(function () use ($shop){
            if (!$shop->delete()){
                throw new \Exception('Ca\'t delete');
            }
        }, ShopResponseEnum::SHOP_DELETE);
    }

    public function shop_sellers(Shop $shop)
    {
        return $this->execute(function () use ($shop){
                $sellers = Seller::query()->where('shop_id', $shop->id)->get();
            return UpdateSellerResource::collection($sellers->load('user', 'shop'));
        }, ShopResponseEnum::SHOP_SELLERS);
    }
}

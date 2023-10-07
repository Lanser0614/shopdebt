<?php

namespace App\Http\Controllers;

use App\Constants\ResponseConstants\ShopResponseEnum;
use App\Http\Requests\Shop\ShopRequest;
use App\Http\Requests\Shop\UpdateShopRequest;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\Seller\UpdateSellerResource;
use App\Http\Resources\Shop\ShopResource;
use App\Models\Seller;
use App\Models\Shop;
use App\Models\User;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Shop::class, 'shop');
    }

    public function store(ShopRequest $request)
    {
        return $this->execute(function () use ($request){
            $validated = $request->validated();
            $validated['user_id'] = auth()->id();
            $shop = Shop::query()->create($validated);
            return ShopResource::make($shop->load('user'));
        }, ShopResponseEnum::SHOP_CREATE);
    }

    public function show(Shop $shop)
    {
        return $this->execute(function () use ($shop){
            return ShopResource::make($shop->load('user'));
        }, ShopResponseEnum::SHOP_INFO);
    }

    public function update(UpdateShopRequest $request, Shop $shop)
    {
        return $this->execute(function () use ($request, $shop){
            $validated = $request->validated();
            $validated['user_id'] = auth()->id();
            $shop->update($validated);
            return ShopResource::make($shop->load('user'));
        }, ShopResponseEnum::SHOP_UPDATE);
    }

    public function destroy(Shop $shop)
    {
        return $this->execute(function () use ($shop){
            if (!$shop->delete()){
                throw new \Exception('Ca\'t delete');
            }
        }, ShopResponseEnum::SHOP_DELETE);
    }

    public function user_shops()
    {
        return $this->execute(function () {
            $shops = User::query()->find(auth()->id())->shops;
            return ShopResource::collection($shops);
        }, ShopResponseEnum::USER_SHOPS);
    }

    public function shop_sellers(Shop $shop)
    {
        $this->authorize('shop_sellers', $shop);
        return $this->execute(function () use ($shop){
            $sellers = Seller::query()->where('shop_id', $shop->id)->get();
            return UpdateSellerResource::collection($sellers->load('user', 'shop'));
        }, ShopResponseEnum::SHOP_SELLERS);
    }

    public function shop_clients(Shop $shop)
    {
        $this->authorize('shop_clients', $shop);
        return $this->execute(function () use ($shop){
            $clients = $shop->clients;
            return ClientResource::collection($clients);
        }, ShopResponseEnum::SHOP_CLIENTS);
    }

    public function shop_products(Shop $shop)
    {
        $this->authorize('shop_clients', $shop);
        return $this->execute(function () use ($shop){
            $products = $shop->products;
            return ProductResource::collection($products);
        }, ShopResponseEnum::SHOP_PRODUCTS);
    }
}

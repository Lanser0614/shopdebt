<?php

namespace App\Http\Controllers;

use App\Constants\ResponseConstants\ProductResponseEnum;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        return $this->execute(function () use ($request){
            $validated = $request->validated();
            if (!auth()->user()->checkShopId($validated['shop_id'])){
                throw new \Exception('Invalid shop id');
            }
            $product = Product::query()->create($validated);
            return ProductResource::make($product->load('shop'));
        }, ProductResponseEnum::PRODUCT_CREATE);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $this->execute(function () use ($product){
            return ProductResource::make($product->load('shop'));
        }, ProductResponseEnum::PRODUCT_SHOW);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        return $this->execute(function () use ($request, $product){
            $validated = $request->validated();
            $product->update($validated);
            return ProductResource::make($product->load('shop'));
        }, ProductResponseEnum::PRODUCT_UPDATE);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        return $this->execute(function () use ($product){
            if (!$product->delete()){
                throw new \Exception('Can\'t delete');
            }
        }, ProductResponseEnum::PRODUCT_DELETED);
    }
}

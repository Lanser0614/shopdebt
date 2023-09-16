<?php

namespace App\Http\Resources;

use App\Http\Resources\Shop\ShopResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'shop' => ShopResource::make($this->whenLoaded('shop')),
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description
        ];
    }
}

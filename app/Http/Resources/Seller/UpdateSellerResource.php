<?php

namespace App\Http\Resources\Seller;

use App\Http\Resources\Shop\ShopResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UpdateSellerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => UserResource::make($this->whenLoaded('user')),
            'shop' => ShopResource::make($this->whenLoaded('shop')),
            'label' => $this->label
        ];
    }
}

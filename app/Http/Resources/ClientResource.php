<?php

namespace App\Http\Resources;

use App\Http\Resources\Shop\ShopResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'shop' => ShopResource::make($this->whenLoaded('shop')) ,
            'name' => $this->name,
            'phone' => $this->phone_number,
            'address' => $this->address
        ];
    }
}

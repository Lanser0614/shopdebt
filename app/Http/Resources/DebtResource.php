<?php

namespace App\Http\Resources;

use App\Http\Resources\Shop\ShopResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DebtResource extends JsonResource
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
            'seller' => UserResource::make($this->whenLoaded('user')),
            'client' => ClientResource::make($this->whenLoaded('client')),
            'comment' => $this->comment,
            'amount' => $this->amount,
            'deadline' => Carbon::make($this->deadline)->format('d-m-Y-H')
        ];
    }
}

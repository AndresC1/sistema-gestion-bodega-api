<?php

namespace App\Http\Resources\Purchase;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\DetailsPurchaseCleanResource;

class PurchaseCleanResource extends JsonResource
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
            'number_bill' => $this->number_bill,
            'provider' => $this->provider->name,
            'user' => $this->user->name,
            'date' => $this->date,
            'total' => $this->total,
            'details' => DetailsPurchaseCleanResource::collection($this->detailsPurchase),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

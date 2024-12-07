<?php

namespace App\Http\Resources;

use App\Http\Resources\Product\ProductCleanResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailsPurchaseCleanResource extends JsonResource
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
            'purchase_id' => $this->purchase_id,
            'product' => new ProductCleanResource($this->product),
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total' => $this->total,
            'disponibility' => $this->disponibility,
            'observation' => $this->observation,
        ];
    }
}

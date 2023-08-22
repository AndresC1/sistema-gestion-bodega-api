<?php

namespace App\Http\Resources\DetailsInputProduct;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailsInputProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product' => $this->detailsPurchase->product->name,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total' => $this->total,
        ];
    }
}

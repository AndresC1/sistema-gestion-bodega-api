<?php

namespace App\Http\Resources\EntryProduct;

use App\Http\Resources\DetailsInputProduct\DetailsInputProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntryProductResource extends JsonResource
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
            'user' => $this->user->name,
            'date' => $this->date,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total' => $this->total,
            'products' => DetailsInputProductResource::collection($this->detailsProductInputs),
            'disponibility' => $this->disponibility,
            'observation' => $this->observation,
        ];
    }
}

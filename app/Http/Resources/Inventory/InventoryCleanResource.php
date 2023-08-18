<?php

namespace App\Http\Resources\Inventory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryCleanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product' => $this->product->name,
            'type' => $this->type,
            'stock' => $this->stock,
            'stock_min' => $this->stock_min,
            'measurement_type' => $this->product->measurement_type,
            'unit_of_measurement' => $this->unit_of_measurement,
            'location' => $this->location,
            'date_last_modified' => $this->date_last_modified,
            'lot_number' => $this->lot_number,
            'note' => $this->note,
            'status' => $this->status,
            'total_value' => $this->total_value,
            'code' => $this->code,
            'description' => $this->description,
        ];
    }
}

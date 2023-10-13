<?php

namespace App\Http\Resources\Sale;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleCleanResource extends JsonResource
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
            'client_id' => $this->client->name,
            'user_id' => $this->user->name,
            'date' => $this->date,
            'total' => $this->total,
            'earning_total' => $this->earning_total,
            'note' => $this->note,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
        ];
    }
}

<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientCleanResource extends JsonResource
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
            'name' => $this->name,
            'organization_id' => $this->organization->name,
            'type' => $this->type,
            'phone_main' => $this->phone_main,
            'phone_secondary' => $this->phone_secondary,
            'status' => $this->status,
        ];
    }
}

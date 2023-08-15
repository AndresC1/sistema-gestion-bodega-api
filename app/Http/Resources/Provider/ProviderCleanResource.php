<?php

namespace App\Http\Resources\Provider;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderCleanResource extends JsonResource
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
            'email' => $this->email,
            'ruc' => $this->ruc,
            'organization' => $this->organization->name,
            'municipality' => $this->municipality->name,
            'city' => $this->city->name,
            'contact_name' => $this->contact_name,
            'address' => $this->address,
            'phone_main' => $this->phone_main,
            'phone_secondary' => $this->phone_secondary,
            'details' => $this->details,
        ];
    }
}

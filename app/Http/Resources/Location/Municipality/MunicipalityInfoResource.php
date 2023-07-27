<?php

namespace App\Http\Resources\Location\Municipality;

use App\Http\Resources\Location\City\CityResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MunicipalityInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "municipio" => MunicipalityResource::make($this),
            "ciudad" => CityResource::make($this->city),
        ];
    }
}

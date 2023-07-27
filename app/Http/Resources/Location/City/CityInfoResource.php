<?php

namespace App\Http\Resources\Location\City;

use App\Http\Resources\Location\Municipality\MunicipalityResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "ciudad" => CityResource::make($this),
            "municipios" => MunicipalityResource::collection($this->municipalities),
        ];
    }
}

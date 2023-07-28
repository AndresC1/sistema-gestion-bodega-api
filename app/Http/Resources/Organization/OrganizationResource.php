<?php

namespace App\Http\Resources\Organization;

use App\Http\Resources\Location\City\CityResource;
use App\Http\Resources\Location\Municipality\MunicipalityResource;
use App\Http\Resources\Sector\SectorResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "ruc" => $this->ruc,
            "address" => $this->address,
            "sector" => SectorResource::make($this->sector),
            "municipality" => MunicipalityResource::make($this->municipality),
            "city" => CityResource::make($this->city),
            "phone_main" => $this->phone_main,
            "phone_secondary" => $this->phone_secondary,
        ];
    }
}

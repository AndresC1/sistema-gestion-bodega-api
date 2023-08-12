<?php

namespace App\Http\Controllers;

use App\Http\Resources\Organization\OrganizationResource;
use App\Http\Resources\Sector\SectorResource as Sector_SectorResource;
use App\Models\Organization;
use App\Models\Sector;
use Exception;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function index()
    {
        try{
            return response()->json([
                'sectores' => Sector_SectorResource::collection(Sector::all()),
                'mensaje' => 'Sectores obtenidos correctamente',
                'estado' => 200
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener los sectores',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
    public function organization_for_sector(Sector $sector){
        try{
            $organizations = Organization::where("sector_id", $sector->id)->paginate(10);
            return response()->json([
                "organizaciones" => OrganizationResource::collection($organizations),
                "meta" => [
                    "total" => $organizations->total(),
                    "current_page" => $organizations->currentPage(),
                    "last_page" => $organizations->lastPage(),
                    "per_page" => $organizations->perPage()
                ],
                "links" => [
                    "first" => $organizations->url(1),
                    "last" => $organizations->url($organizations->lastPage()),
                    "prev" => $organizations->previousPageUrl(),
                    "next" => $organizations->nextPageUrl()
                ],
                "mensaje" => "Organizaciones del sector ".$sector->name,
                "estado" => 200
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'mensaje' => 'Error al obtener las organizaciones del sector '.$sector->name,
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Http\Resources\Location\City\CityInfoResource;
use App\Models\City;
use Exception;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{
    public function show(City $city)
    {
        try{
            return response()->json([
                'info' => CityInfoResource::make($city),
                'mensaje' => 'Municipios de '.$city->name.' obtenidos correctamente',
                'estado' => 200
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener los municipios de la ciudad',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
}

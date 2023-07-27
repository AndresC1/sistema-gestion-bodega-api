<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Http\Resources\Location\City\CityResource;
use App\Models\City;
use Exception;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        try{
            return response()->json([
                'ciudades' => CityResource::collection(City::all()),
                'mensaje' => 'Ciudades obtenidas correctamente',
                'estado' => 200
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener las ciudades',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
}

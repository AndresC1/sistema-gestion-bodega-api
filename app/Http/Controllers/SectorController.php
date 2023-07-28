<?php

namespace App\Http\Controllers;

use App\Http\Resources\Sector\SectorResource as Sector_SectorResource;
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
                'estado' => 'error'
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\ExportarExcel;

use App\Exports\MultiplesSheet;
use App\Exports\sheetscomplete;
use App\Exports\SheetsPurchase;
use App\Exports\SheetsSales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Parser\Multiple;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller

{
    
    public function CompleteExport(Request $request){
        $data = $request->json()->all();

        if (isset($data['fechas']) && is_array($data['fechas'])) {
           

            $fechas = $data['fechas'];

            if (count($fechas) === 2) {

                $fecha1 = $fechas[0];
                $fecha2 = $fechas[1];

            } else {
                // Manejo de error si no hay dos fechas en el array.
                return response()->json([
                    'mensaje' => 'fechas incorrectas',
                    'estado' => 400
                ], 400);
                
            }
        } else {
            // Manejo de error si la clave 'fechas' no está definida o no es un array.
            return response()->json([
                'mensaje' => 'Las fechas no son un array',
                'estado' => 400
            ], 400);
        }
        $organization_name = Auth::user()->organization->name;
        return (new sheetscomplete($fecha1, $fecha2))->download($organization_name . '-' . $fecha1 . '_' . $fecha2 . '-Reporte.xlsx');

        
    }
    
}

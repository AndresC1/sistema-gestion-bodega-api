<?php

namespace App\Http\Controllers\ExportarExcel;

use App\Exports\sheetscomplete;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller

{
    private function validateAndFormatDates($fechas)
    {
        if (is_array($fechas) && count($fechas) === 2) {
            $fecha1 = $fechas[0];
            $fecha2 = $fechas[1];

            $carbonFecha1 = Carbon::createFromFormat('Y-m-d', $fecha1);
            $carbonFecha2 = Carbon::createFromFormat('Y-m-d', $fecha2);

            if ($carbonFecha1->lessThan($carbonFecha2)) {
                return [
                    'fecha1' => $carbonFecha1->format('Y-m-d'),
                    'fecha2' => $carbonFecha2->format('Y-m-d'),
                ];
            }
        }
        return null;
    }

    private function getOrganizationName()
    {
        return Auth::user()->organization->name;
    }

    private function generateExcel($fechasFormateadas, $sheetType, $sheetTypeName)
    {
        $organization_name = $this->getOrganizationName();
        if ($fechasFormateadas) {
            return (new sheetscomplete($fechasFormateadas['fecha1'], $fechasFormateadas['fecha2'], $sheetType))
                ->download($organization_name . '-' . $fechasFormateadas['fecha1'] . '_' . $fechasFormateadas['fecha2'] . '-' . $sheetTypeName . '-Reporte.xlsx');
        }
        return null;
    }

    public function InventoryMP(Request $request)
    {
        $fechas = $request->input('fechas');
        $fechasFormateadas = $this->validateAndFormatDates($fechas);
        return $this->generateExcel($fechasFormateadas, 1, 'Materia_Prima');
    }

    public function InventoryPT(Request $request)
    {
        $fechas = $request->input('fechas');
        $fechasFormateadas = $this->validateAndFormatDates($fechas);
        return $this->generateExcel($fechasFormateadas, 2, 'Producto_Terminado');
    }

    public function BestSeller(Request $request)
    {
        $fechas = $request->input('fechas');
        $fechasFormateadas = $this->validateAndFormatDates($fechas);
        return $this->generateExcel($fechasFormateadas, 3, 'Mejor_Vendido');
    }

    public function Sales(Request $request)
    {
        $fechas = $request->input('fechas');
        $fechasFormateadas = $this->validateAndFormatDates($fechas);
        return $this->generateExcel($fechasFormateadas, 5, 'Ventas');
    }

    public function Purchase(Request $request)
    {
        $fechas = $request->input('fechas');
        $fechasFormateadas = $this->validateAndFormatDates($fechas);
        return $this->generateExcel($fechasFormateadas, 6, 'Compras');
    }
    public function Low(Request $request)
    {
        $fechas = $request->input('fechas');
        $fechasFormateadas = $this->validateAndFormatDates($fechas);
        return $this->generateExcel($fechasFormateadas, 4, 'Menos_Vendido');
    }
}

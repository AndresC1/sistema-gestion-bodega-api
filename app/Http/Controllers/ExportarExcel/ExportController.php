<?php

namespace App\Http\Controllers\ExportarExcel;

use App\Exports\SheetProduct;
use App\Exports\sheetscomplete;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller

{
    public function exportReport(Request $request, $sheetType, $sheetTypeName)
    {

        $fromDate = str_replace('"', '', $request->input('fromDate'));
        $toDate = str_replace('"', '', $request->input('toDate'));
        $Producto = $request->input('product');
        
    
        // Verificar las fechas
        $fechasFormateadas = $this->validateAndFormatDates($fromDate,$toDate);
    
        // Verificar la existencia del producto si se proporciona un nombre
        if (!empty($Producto)) {
            $nombreProducto = Product::where('id', $Producto)->value('name');
    
            // Comprobar si el producto existe
            if (!$nombreProducto) {
                return response()->json([
                    'mensaje' => 'El producto especificado no se encuentra en la base de datos',
                    'estado' => 400
                ], 400);
            }
           // Obtén la organización del usuario autenticado
            $organizacionUsuario = Auth::user()->organization;

            // Comprueba si la organización del producto coincide con la organización del usuario autenticado
            $inventariosDelProducto = Product::find($Producto)->inventories;


            $inventarioValido = $inventariosDelProducto->first(function ($inventario) use ($organizacionUsuario) {
                return $inventario->organization->id === $organizacionUsuario->id;
            });
    

            if (!$inventarioValido) {
                return response()->json([
                    'mensaje' => 'El producto no pertenece a la organización actual',
                    'estado' => 400
                ], 400);
            }
        }
    
        // Generar el informe para el producto específico si existe
        if (!empty($nombreProducto)) {
            // Utiliza $fechasFormateadas y $producto para generar el informe
            return $this->generateProduct($fechasFormateadas, $sheetType, $sheetTypeName, $nombreProducto);
        } else {
            // Generar el informe para todos los productos o para un informe predeterminado si no se proporciona un nombre de producto
            // Utiliza $fechasFormateadas para generar el informe sin filtrar por producto
            return $this->generateExcel($fechasFormateadas, $sheetType, $sheetTypeName);
        }
    }


    private function validateAndFormatDates($fromDate, $toDate)
    {
        $fecha1 = $fromDate;
        $fecha2 = $toDate;

        $carbonFecha1 = Carbon::createFromFormat('Y-m-d', $fecha1);
        $carbonFecha2 = Carbon::createFromFormat('Y-m-d', $fecha2);

        if ($carbonFecha1->lessThanOrEqualTo($carbonFecha2)) {
            return [
                'fecha1' => $carbonFecha1->format('Y-m-d'),
                'fecha2' => $carbonFecha2->format('Y-m-d'),
            ];
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
                ->download($organization_name . '-' . $fechasFormateadas['fecha1'] . '_' . $fechasFormateadas['fecha2'] . '-' . $sheetTypeName . '-Reporte.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        }
        return null;
    }
    private function generateProduct($fechasFormateadas, $sheetType, $sheetTypeName, $producto)
    {
        $organization_name = $this->getOrganizationName();
        if ($fechasFormateadas) {
            return (new sheetscomplete($fechasFormateadas['fecha1'], $fechasFormateadas['fecha2'], $sheetType,$producto))
                ->download($organization_name . '-' . $fechasFormateadas['fecha1'] . '_' . $fechasFormateadas['fecha2'] . '-' . $sheetTypeName . '-Reporte.xlsx' , \Maatwebsite\Excel\Excel::XLSX);
        }
        return null;
    }

    public function InventoryMP(Request $request)
    {
        return $this->exportReport($request, 1, 'Materia_Prima');
    }

    public function InventoryPT(Request $request)
    {
        return $this->exportReport($request, 2, 'Producto_Terminado');
    }

    public function BestSeller(Request $request)
    {
        return $this->exportReport($request, 3, 'Mejor_Vendido');
    }

    public function Sales(Request $request)
    {
        return $this->exportReport($request, 5, 'Ventas');
    }

    public function Purchase(Request $request)
    {
        return $this->exportReport($request, 6, 'Compras');
    }

    public function Low(Request $request)
    {
        return $this->exportReport($request, 4, 'Menos_Vendido');
    }
    public function Nada(Request $request)
    {

        $organization_name = $this->getOrganizationName();
        return (new sheetscomplete('2023-01-01','2023-12-12', 1))
        ->download($organization_name . '-' . '2023-01-01 -'.'2023-12-24' . '-' . 'Prueba' . '-Reporte.xlsx');
    }
}

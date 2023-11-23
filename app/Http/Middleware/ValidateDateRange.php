<?php

namespace App\Http\Middleware;

use App\Models\Product;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Exception;

class ValidateDateRange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
        {
            
        // Obtener datos del request
        $fromDate = str_replace('"', '', $request->input('fromDate'));
        $toDate = str_replace('"', '', $request->input('toDate'));
        $Producto = $request->input('product');

        // Validar que ambas fechas sean cadenas
        if (is_string($fromDate) && is_string($toDate)) {
            try {
                // Intentar crear objetos Carbon para ambas fechas
                $carbonFromDate = Carbon::createFromFormat('Y-m-d', $fromDate);
                $carbonToDate = Carbon::createFromFormat('Y-m-d', $toDate);
            } catch (Exception $e) {
                return response()->json([
                    'mensaje' => 'Fecha incorrecta',
                    'estado' => 400
                ], 400);
            }

            // Verificar que las fechas sean válidas
            if ($carbonFromDate !== false && $carbonToDate !== false) {
                if ($carbonFromDate->lessThanOrEqualTo($carbonToDate)) {
                    // Verificar que el rango de fechas no sea excesivamente largo (en este caso, no más de 100 años)
                    $diferenciaAnios = $carbonFromDate->diffInYears($carbonToDate);
                    if ($diferenciaAnios <= 100) {
                        if (!empty($Producto)) {
                            // Verificar la existencia del producto en la base de datos, si se proporciona
                            $nombreProducto = Product::where('id', $Producto)->value('name');
                        
                            // Comprobar si el producto existe
                            if (!$nombreProducto) {
                                return response()->json([
                                    'mensaje' => 'El producto especificado no se encuentra en la base de datos',
                                    'estado' => 400
                                ], 400);
                            }

                           
                        }
                         // Continuar con la solicitud si todas las validaciones son exitosas
                         return $next($request);
                        
                    } else {
                        return response()->json([
                            'mensaje' => 'El rango de fechas es demasiado largo (más de 100 años)',
                            'estado' => 400
                        ], 400);
                    }
                } else {
                    return response()->json([
                        'mensaje' => 'La fecha inicial debe ser menor que la fecha final',
                        'estado' => 400
                    ], 400);
                }
            } else {
                return response()->json([
                    'mensaje' => 'Fechas inválidas',
                    'estado' => 400
                ], 400);
            }
        } else {
            return response()->json([
                'mensaje' => 'Las fechas deben ser cadenas de texto',
                'estado' => 400
            ], 400);
        }
    }
}
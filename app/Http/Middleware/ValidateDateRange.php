<?php

namespace App\Http\Middleware;

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
            $data = $request->json()->all();

            if (isset($data['fechas']) && is_array($data['fechas']) && count($data['fechas']) === 2) {
                $fecha1 = $data['fechas'][0];
                $fecha2 = $data['fechas'][1];
        
                // Validar que ambas fechas sean cadenas
                if (is_string($fecha1) && is_string($fecha2)) {
                    // Intentar crear objetos Carbon para ambas fechas
                   try{
                    $carbonFecha1 = Carbon::createFromFormat('Y-m-d', $fecha1);
                    $carbonFecha2 = Carbon::createFromFormat('Y-m-d', $fecha2);
                   }catch(Exception $e){
                    return response()->json([
                        'mensaje' => 'Fecha incorrecta',
                        'estado' => 400
                    ], 400);
                   }
        
                    // Verificar que las fechas sean válidas
                    if ($carbonFecha1 !== false && $carbonFecha2 !== false) {
                        if ($carbonFecha1->lessThan($carbonFecha2)) {
                            // Verificar que el rango de fechas no sea excesivamente largo (en este caso, no más de 100 años)
                            $diferenciaAnios = $carbonFecha1->diffInYears($carbonFecha2);
                            if ($diferenciaAnios <= 100) {
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
            } else {
                return response()->json([
                    'mensaje' => 'Fechas incorrectas',
                    'estado' => 400
                ], 400);
            }
        }
}
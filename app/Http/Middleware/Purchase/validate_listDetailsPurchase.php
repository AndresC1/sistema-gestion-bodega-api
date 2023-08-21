<?php

namespace App\Http\Middleware\Purchase;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class validate_listDetailsPurchase
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data_detailsPurchase = $request->json()->all();
        if($data_detailsPurchase == null || $data_detailsPurchase == []){
            return response()->json([
                'mensaje' => 'La lista de detalles de compra es requerida',
                'estado' => 422
            ], 422);
        }
        return $next($request);
    }
}

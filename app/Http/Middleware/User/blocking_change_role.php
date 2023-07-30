<?php

namespace App\Http\Middleware\User;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class blocking_change_role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->role_id == 1){
            return response()->json([
                'mensaje' => 'No se puede cambiar a este rol',
                'estado' => 403
            ], 403);
        }
        return $next($request);
    }
}

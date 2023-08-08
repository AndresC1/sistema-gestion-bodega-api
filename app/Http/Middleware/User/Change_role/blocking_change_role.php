<?php

namespace App\Http\Middleware\User\Change_role;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class blocking_change_role
{
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

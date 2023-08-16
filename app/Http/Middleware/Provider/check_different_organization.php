<?php

namespace App\Http\Middleware\Provider;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class check_different_organization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()->organization_id != $request->provider->organization_id){
            return response([
                'message' => 'No tienes acceso a datos de otras organizaciones',
                'estado' => 403
            ], 403);
        }
        return $next($request);
    }
}

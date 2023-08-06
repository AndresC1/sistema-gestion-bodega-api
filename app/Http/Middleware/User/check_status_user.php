<?php

namespace App\Http\Middleware\User;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class check_status_user
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->username == null){
            return response()->json([
                'mensaje' => 'username es requerido',
                'estado' => 404
            ], 404);
        }
        if(User::where('username', $request->username)->first()->status == 'inactive'){
            return response()->json([
                'mensaje' => 'Usuario inactivo',
                'estado' => 403
            ], 403);
        }
        return $next($request);
    }
}

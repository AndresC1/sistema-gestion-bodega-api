<?php

namespace App\Http\Middleware\User\Change_status;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class check_role_super_admin
{
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->id == $request->route('user')->id){
            return $next($request);
        }
        if($request->route('user')->role_id == 1){
            return response()->json([
                'message' => 'No tienes permitido cambiar los datos de un super administrador',
                'estado' => 403
            ], 403);
        }
        return $next($request);
    }
}

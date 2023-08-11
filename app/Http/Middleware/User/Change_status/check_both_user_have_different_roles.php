<?php

namespace App\Http\Middleware\User\Change_status;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class check_both_user_have_different_roles
{
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->id == $request->route('user')->id){
            return $next($request);
        }
        if($request->route('user')->role_id == Auth::user()->role_id){
            if($request->route('user')->status == "inactive"){
                return $next($request);
            }
            return response()->json([
                'message' => 'No puedes cambiar los datos de un usuario con el mismo rol que tú',
                'estado' => 403
            ], 403);
        }
        return $next($request);
    }
}

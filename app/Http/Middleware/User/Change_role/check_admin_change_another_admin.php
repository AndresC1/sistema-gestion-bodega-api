<?php

namespace App\Http\Middleware\User\Change_role;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class check_admin_change_another_admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->role_id == 2 && User::find($request->user_id)->role_id == 2){
            return response()->json([
                'mensaje' => 'No se puede cambiar el rol a otro admin',
                'estado' => 403
            ], 403);
        }
        return $next($request);
    }
}

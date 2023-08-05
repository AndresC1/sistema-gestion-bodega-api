<?php

namespace App\Http\Middleware\Permission\Change_rol;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class check_admin_change_user_super_admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->role_id == 2 && User::find($request->user_id)->role_id == 1){
            return response()->json([
                'message' => 'Admin no puede cambiar rol a un super admin',
            ], 403);
        }
        return $next($request);
    }
}

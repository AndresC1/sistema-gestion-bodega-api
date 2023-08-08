<?php

namespace App\Http\Middleware\User\Change_role;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class check_different_organization
{
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->role_id == 1){
            return $next($request);
        }
        if(Auth::user()->organization_id != User::find($request->user_id)->first()->organization_id){
            return response()->json([
                'message' => 'No puedes cambiar el rol de un usuario de otra organizacion',
            ], 403);
        }
        return $next($request);
    }
}

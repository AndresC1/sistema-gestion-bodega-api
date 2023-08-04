<?php

namespace App\Http\Middleware\Permission\Organization;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class match_organization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->role_id == 1 || Auth::user()->id == $request->route('user')->id){
            return $next($request);
        }
        if(Auth::user()->organization_id != $request->route('user')->organization_id){
            return response()->json([
                'message' => 'No eres miembro de esta organización',
                'estado' => 403
            ], 403);
        }
        return $next($request);
    }
}

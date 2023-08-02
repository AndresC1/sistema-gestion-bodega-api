<?php

namespace App\Http\Middleware\Permission;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class check_permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$params): Response
    {
        $id_permission = Permission::where('name', $params[0])->first()->id;
        if(!Auth::user()->role->role_permission->map->permission_id->contains($id_permission)){
            return response()->json([
                'mensaje' => 'No tienes permiso para realizar esta acción',
                'estado' => 403
            ], 403);
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware\Permission\Organization;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class view_list_organization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id_permission = Permission::where('name', 'view_list_organization')->first()->id;
        if(!Auth::user()->role->role_permission->map->permission_id->contains($id_permission)){
            return response()->json([
                'mensaje' => 'No tienes permiso para ver la lista de organizaciones',
                'estado' => 403
            ], 403);
        }
        return $next($request);
    }
}

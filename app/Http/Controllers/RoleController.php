<?php

namespace App\Http\Controllers;

use App\Http\Resources\Role\RoleInfoResource;
use App\Http\Resources\User\UserInfoResource;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $listaRoles = Role::where('name', '!=', 'super_admin')->get();
        try{
            return response()->json([
                'roles' => RoleInfoResource::collection($listaRoles),
                'mensaje' => 'Roles obtenidos correctamente',
                'estado' => 200
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener los roles',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
    public function change_role_by_user(Request $request){
        try{
            $user = User::find($request->user_id);
            $user->role_id = $request->role_id;
            $user->save();
            return response()->json([
                'user' => UserInfoResource::make($user),
                'mensaje' => 'Rol cambiado correctamente',
                'estado' => 200
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'mensaje' => 'Error al cambiar el rol del usuario',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
}

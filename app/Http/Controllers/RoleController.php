<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexRequest;
use App\Http\Resources\Role\RoleInfoResource;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\User\UserInfoResource;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(IndexRequest $request)
    {
        try{
            $request->validated();
            if($request->search){
                $roles = Role::where("name", "like", "%".$request->search."%")
                    ->where('name', '!=', 'super_admin')
                    ->orderBy($request->orderBy ?? "id", $request->order ?? "asc")
                    ->paginate($request->limit);
            }else{
                $roles = Role::orderBy($request->orderBy ?? "id", $request->order ?? "asc")
                    ->where('name', '!=', 'super_admin')
                    ->paginate($request->limit);
            }
            return response()->json([
                'roles' => RoleResource::collection($roles),
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

    public function show(Role $role){
        try{
            if($role->name == 'super_admin'){
                return response()->json([
                    'mensaje' => 'No se puede obtener el rol super_admin',
                    'estado' => 400
                ], 400);
            }
            return response()->json([
                'role' => RoleInfoResource::make($role),
                'mensaje' => 'Rol obtenido correctamente',
                'estado' => 200
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener el rol',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
}

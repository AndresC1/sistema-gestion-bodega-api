<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserInfoResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show()
    {
        try{
            return response()->json([
                'usuario' => UserInfoResource::make(Auth::user()),
                'mensaje' => 'Datos del usuario',
                'estado' => 200
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los datos del usuario',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
    public function change_status(User $user){
        try{
            $user->status = $user->status == 'active' ? 'inactive' : 'active';
            $user->save();
            if($user->status == 'inactive'){
                $user->tokens()->delete();
            }
            return response()->json([
                'usuario' => UserInfoResource::make($user),
                'mensaje' => 'El estado del usuario cambio',
                'estado' => 200
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'mensaje' => 'Error al cambiar el estado del usuario',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
    public function update(UpdateUserRequest $request, User $user){
        try{
            $user->update($request->validated());
            return response()->json([
                'usuario' => UserInfoResource::make($user),
                'mensaje' => 'El usuario se actualizo correctamente',
                'estado' => 200
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'mensaje' => 'Error al actualizar el usuario',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ChangePasswordUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserCleanResource;
use App\Http\Resources\User\UserInfoResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        try{
            $users = User::paginate(10);
            $users_list = $users->filter(function ($user) {
                return $user->id !== auth()->user()->id;
            });
            return response()->json([
                'usuarios' => UserCleanResource::collection($users_list),
                'meta' => [
                    'total' => $users->total(),
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'per_page' => $users->perPage(),
                ],
                'links' => [
                    'first' => $users->url(1),
                    'last' => $users->url($users->lastPage()),
                    'prev' => $users->previousPageUrl(),
                    'next' => $users->nextPageUrl(),
                ],
                'mensaje' => 'Usuarios obtenidos correctamente',
                'estado' => 200
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener los usuarios',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
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
    public function update(UpdateUserRequest $request){
        try{
            $request->validated();
            $user = Auth::user();
            $user->update([
                'name' => $request->name??$user->name,
                'email' => $request->email??$user->email,
            ]);
            return response()->json([
                'usuario' => UserCleanResource::make($user),
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
    public function change_password(ChangePasswordUserRequest $request){
        try{
            $request->validated();
            Auth::user()->update([
                'password' => Hash::make($request->password),
                'verification_password' => 1,
            ]);;
            Auth::user()->tokens()->delete();
            return response()->json([
                'mensaje' => 'Contraseña cambiada correctamente',
                'estado' => 200
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'mensaje' => 'Error al cambiar la contraseña',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
}

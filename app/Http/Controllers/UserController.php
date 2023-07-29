<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\UserInfoResource;
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
}

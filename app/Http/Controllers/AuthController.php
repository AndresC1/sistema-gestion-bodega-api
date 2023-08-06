<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\ValidateUserRequest;
use App\Http\Resources\User\UserInfoResource;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validation = new StoreUserRequest();
        $request->validate($validation->rules(), $validation->messages());

        $password_generated = $this->generatePassword();
        $user = new User([
            'name' => $request->name,
            'email' => $request->email ?? null,
            'password' => Hash::make($password_generated),
            'role_id' => $request->role_id,
            'organization_id' => $request->organization_id,
            'username' => $request->username,
            'last_login_at' => now(),
            'status' => 'active',
            'verification_password' => 0
        ]);

        $user->save();

        return response()->json([
            'usuario' => UserInfoResource::make($user),
            'password' => $password_generated,
            'verificacion_password' => $user->verification_password,
            'mensaje' => 'Usuario creado exitosamente!',
            'estado' => 201
        ], 201);
    }

    public function login(Request $request)
    {
        $validate = new ValidateUserRequest();
        $request->validate($validate->rules(), $validate->messages());

        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'message' => 'Datos incorrectos',
                'estado' => 401
            ], 401);
        }

        auth()->user()->tokens()->delete();

        $user = User::where('username', $request->username)->firstOrFail();
        $user->last_login_at = now();
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'usuario' => UserInfoResource::make($user),
            'token' => $token,
            'token_type' => 'Bearer',
            'mensaje' => 'Login exitoso',
            'estado' => 200
        ], 201);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'mensaje' => 'Logout exitoso',
            'estado' => 200
        ], 200);
    }

    private function generatePassword(){
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789*#@$%&_";
        $password = substr(str_shuffle($chars), 0, 20);
        return $password;
    }
}

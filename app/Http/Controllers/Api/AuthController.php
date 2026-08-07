<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;

class AuthController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', except: ['login']),
        ];
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $user = auth('api')->user();
        $role = $user->roles()->get()->first();
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60,
            'user'         => $user,
            'role'         => $role ? $role->name : null,
        ]);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['mensaje' => 'Cierre de sesión exitoso']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ]);
    }
}

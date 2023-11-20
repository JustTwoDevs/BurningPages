<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validar que el usuari haya provisto los datos necesarios
        // para hacer la autenticación: "email" y "password".
        try {
            $request->validate([
                'username' => 'required|string|min:3|max:255',
                'password' => 'required|string|min:3|max:255',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->status);
        }
        // Verificar que los datos provistos sean los correctos y que
        // efectivamente el usuario se autentique con ellos utilizando
        // los datos de la tabla "users".
        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }
        // Una vez autenticado, obtener la información del usuario en sesión.
        $tokenType = 'Bearer';
        $user = User::where('username', $request['username'])->first();
        if (!$user) {
            $user = Admin::where('username', $request['username'])->firstOrFail();
        }
        // Borrar los tokens anteriores (tipo Bearer) del usuario para
        // evitar, en este caso, tenga mas de uno del mismo tipo.
        $user->tokens()->where('name', $tokenType)->delete();
        // Crear un nuevo token tipo Bearer para el usuario autenticado.
        $token = $user->createToken($tokenType);
        // Enviar el token recién creado al cliente.
        return response()->json([
            'token' => $token->plainTextToken,
            'type' => $tokenType
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Token revoked'
        ], 200);
    }
}

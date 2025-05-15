<?php

namespace App\UseCases\Auth;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\ValidationException;

class LoginUserUseCase
{
    public function execute(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = JWTAuth::attempt($credentials)) {
            throw ValidationException::withMessages(['error' => 'Credenciais inválidas']);
        }
        return $token;
    }
}

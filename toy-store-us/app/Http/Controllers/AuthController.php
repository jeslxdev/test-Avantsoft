<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\Auth\RegisterUserUseCase;
use App\UseCases\Auth\LoginUserUseCase;
use App\UseCases\Auth\MeUserUseCase;
use App\UseCases\Auth\LogoutUserUseCase;

class AuthController extends Controller
{
    public function register(Request $request, RegisterUserUseCase $useCase)
    {
        $user = $useCase->execute($request);
        return response()->json(['message' => 'Usuário registrado. Código de verificação enviado.'], 201);
    }

    public function login(Request $request, LoginUserUseCase $useCase)
    {   
        $token = $useCase->execute($request);
        return response()->json(['token' => $token]);
    }

    public function me(MeUserUseCase $useCase)
    {
        return response()->json($useCase->execute());
    }

    public function logout(LogoutUserUseCase $useCase)
    {
        $useCase->execute();
        return response()->json(['message' => 'Logout realizado com sucesso']);
    }
}
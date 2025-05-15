<?php

namespace App\UseCases\Auth;

use App\Repositories\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\ValidationException;

class RegisterUserUseCase
{
    private $repository;
    public function __construct(AuthRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    public function execute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }
        $user = $this->repository->createUser([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return $user;
    }
}

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

class MeUserUseCase
{
    public function execute()
    {
        return auth()->user();
    }
}

class LogoutUserUseCase
{
    public function execute()
    {
        auth()->logout();
        return true;
    }
}

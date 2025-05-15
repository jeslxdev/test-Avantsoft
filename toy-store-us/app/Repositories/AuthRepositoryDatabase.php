<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\AuthRepositoryInterface;

class AuthRepositoryDatabase implements AuthRepositoryInterface
{
    public function createUser(array $data): User
    {
        return User::create($data);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}

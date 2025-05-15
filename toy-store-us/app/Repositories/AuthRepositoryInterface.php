<?php

namespace App\Repositories;

use App\Models\User;

interface AuthRepositoryInterface
{
    public function createUser(array $data): User;
    public function findByEmail(string $email): ?User;
}

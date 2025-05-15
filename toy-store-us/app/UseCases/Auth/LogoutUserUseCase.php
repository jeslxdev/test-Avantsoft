<?php

namespace App\UseCases\Auth;

class LogoutUserUseCase
{
    public function execute()
    {
        auth()->logout();
        return true;
    }
}

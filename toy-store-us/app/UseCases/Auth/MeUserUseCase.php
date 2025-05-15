<?php

namespace App\UseCases\Auth;

class MeUserUseCase
{
    public function execute()
    {
        return auth()->user();
    }
}

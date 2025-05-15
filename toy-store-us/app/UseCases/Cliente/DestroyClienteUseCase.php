<?php

namespace App\UseCases\Cliente;

use App\Repositories\ClienteRepositoryInterface;
use Illuminate\Validation\ValidationException;

class DestroyClienteUseCase
{
    private $repository;
    public function __construct(ClienteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    public function execute($id)
    {
        $cliente = $this->repository->find($id);
        if (!$cliente) {
            throw ValidationException::withMessages(['id' => 'Cliente não encontrado']);
        }
        $this->repository->delete($cliente);
        return true;
    }
}

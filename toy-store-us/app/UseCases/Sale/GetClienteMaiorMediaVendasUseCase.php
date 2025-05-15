<?php

namespace App\UseCases\Sale;

use App\Repositories\SaleRepositoryInterface;
use App\Models\Cliente;

class GetClienteMaiorMediaVendasUseCase
{
    private $repository;
    public function __construct(SaleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    public function execute(): ?Cliente
    {
        $clienteId = $this->repository->clienteMaiorMediaVendas();
        return $clienteId ? Cliente::find($clienteId) : null;
    }
}

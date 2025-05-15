<?php

namespace App\UseCases\Sale;

use App\Repositories\SaleRepositoryInterface;
use App\Models\Cliente;

class GetClienteMaiorVolumeVendasUseCase
{
    private $repository;
    public function __construct(SaleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    public function execute(): ?Cliente
    {
        $clienteId = $this->repository->clienteMaiorVolumeVendas();
        return $clienteId ? Cliente::find($clienteId) : null;
    }
}

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

class GetClienteMaiorFrequenciaComprasUseCase
{
    private $repository;
    public function __construct(SaleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    public function execute(): ?Cliente
    {
        $clienteId = $this->repository->clienteMaiorFrequenciaCompras();
        return $clienteId ? Cliente::find($clienteId) : null;
    }
}

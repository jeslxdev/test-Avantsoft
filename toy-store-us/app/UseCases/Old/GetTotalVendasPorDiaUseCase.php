<?php

namespace App\UseCases\Sale;

use App\Repositories\SaleRepositoryDatabase;

class GetTotalVendasPorDiaUseCase
{
    private $repository;

    public function __construct(SaleRepositoryDatabase $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): array
    {
        $vendasPorDia = $this->repository->totalVendasPorDia();
        $valorTotal = $this->repository->valorTotalVendas();
        return [
            'vendas_por_dia' => $vendasPorDia,
            'valor_total' => $valorTotal
        ];
    }
}

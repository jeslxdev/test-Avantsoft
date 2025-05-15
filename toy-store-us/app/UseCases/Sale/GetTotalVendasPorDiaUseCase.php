<?php

namespace App\UseCases\Sale;

use App\Repositories\SaleRepositoryInterface;

class GetTotalVendasPorDiaUseCase
{
    private $repository;
    public function __construct(SaleRepositoryInterface $repository)
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

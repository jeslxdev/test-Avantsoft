<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use App\Models\Sale;
use App\Repositories\SaleRepositoryInterface;

class SaleRepositoryDatabase implements SaleRepositoryInterface
{
    public function totalVendasPorDia(): Collection
    {
        return Sale::selectRaw('data_venda, SUM(valor) as total')
            ->groupBy('data_venda')
            ->get();
    }

    public function valorTotalVendas(): float
    {
        return (float) Sale::sum('valor');
    }

    public function clienteMaiorVolumeVendas(): ?int
    {
        $cliente = Sale::selectRaw('cliente_id, SUM(valor) as total')
            ->groupBy('cliente_id')
            ->orderByDesc('total')
            ->first();
        return $cliente?->cliente_id;
    }

    public function clienteMaiorMediaVendas(): ?int
    {
        $cliente = Sale::selectRaw('cliente_id, AVG(valor) as media')
            ->groupBy('cliente_id')
            ->orderByDesc('media')
            ->first();
        return $cliente?->cliente_id;
    }

    public function clienteMaiorFrequenciaCompras(): ?int
    {
        $cliente = Sale::selectRaw('cliente_id, COUNT(DISTINCT data_venda) as dias_unicos')
            ->groupBy('cliente_id')
            ->orderByDesc('dias_unicos')
            ->first();
        return $cliente?->cliente_id;
    }
}

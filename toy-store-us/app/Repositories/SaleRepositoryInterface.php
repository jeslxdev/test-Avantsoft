<?php

namespace App\Repositories;

use App\Models\Sale;
use Illuminate\Support\Collection;

interface SaleRepositoryInterface
{
    public function totalVendasPorDia(): Collection;
    public function valorTotalVendas(): float;
    public function clienteMaiorVolumeVendas(): ?int;
    public function clienteMaiorMediaVendas(): ?int;
    public function clienteMaiorFrequenciaCompras(): ?int;
}
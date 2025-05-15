<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\Sale\StoreSaleUseCase;
use App\UseCases\Sale\GetTotalVendasPorDiaUseCase;
use App\UseCases\Sale\GetClienteMaiorVolumeVendasUseCase;
use App\UseCases\Sale\GetClienteMaiorMediaVendasUseCase;
use App\UseCases\Sale\GetClienteMaiorFrequenciaComprasUseCase;
use App\Repositories\SaleRepositoryInterface;

class SaleController extends Controller
{
    private $storeSaleUseCase;
    private $getTotalVendasPorDiaUseCase;
    private $getClienteMaiorVolumeVendasUseCase;
    private $getClienteMaiorMediaVendasUseCase;
    private $getClienteMaiorFrequenciaComprasUseCase;
    private $saleRepository;

    public function __construct(
        StoreSaleUseCase $storeSaleUseCase,
        GetTotalVendasPorDiaUseCase $getTotalVendasPorDiaUseCase,
        GetClienteMaiorVolumeVendasUseCase $getClienteMaiorVolumeVendasUseCase,
        GetClienteMaiorMediaVendasUseCase $getClienteMaiorMediaVendasUseCase,
        GetClienteMaiorFrequenciaComprasUseCase $getClienteMaiorFrequenciaComprasUseCase,
        SaleRepositoryInterface $saleRepository
    ) {
        $this->storeSaleUseCase = $storeSaleUseCase;
        $this->getTotalVendasPorDiaUseCase = $getTotalVendasPorDiaUseCase;
        $this->getClienteMaiorVolumeVendasUseCase = $getClienteMaiorVolumeVendasUseCase;
        $this->getClienteMaiorMediaVendasUseCase = $getClienteMaiorMediaVendasUseCase;
        $this->getClienteMaiorFrequenciaComprasUseCase = $getClienteMaiorFrequenciaComprasUseCase;
        $this->saleRepository = $saleRepository;
    }

    public function store(Request $request)
    {
        $sale = $this->storeSaleUseCase->execute($request);
        return response()->json($sale, 201);
    }

    public function totalVendasPorDia()
    {
        $result = $this->getTotalVendasPorDiaUseCase->execute();
        return response()->json($result);
    }

    public function clienteMaiorVolumeVendas()
    {
        $cliente = $this->getClienteMaiorVolumeVendasUseCase->execute();
        if (!$cliente) {
            return response()->json(["id" => null, "info" => null, "estatisticas" => null]);
        }
        return response()->json([
            "id" => $cliente->id,
            "info" => [
                "nomeCompleto" => $cliente->nome,
                "detalhes" => [
                    "email" => $cliente->email,
                    "nascimento" => $cliente->data_nascimento
                ]
            ],
            "estatisticas" => [
                "vendas" => $cliente->sales->map(function($venda) {
                    return [
                        'data' => $venda->data_venda,
                        'valor' => $venda->valor
                    ];
                })
            ]
        ]);
    }

    public function clienteMaiorMediaVendas()
    {
        $cliente = $this->getClienteMaiorMediaVendasUseCase->execute();
        if (!$cliente) {
            return response()->json(["id" => null, "info" => null, "estatisticas" => null]);
        }
        return response()->json([
            "id" => $cliente->id,
            "info" => [
                "nomeCompleto" => $cliente->nome,
                "detalhes" => [
                    "email" => $cliente->email,
                    "nascimento" => $cliente->data_nascimento
                ]
            ],
            "estatisticas" => [
                "vendas" => $cliente->sales->map(function($venda) {
                    return [
                        'data' => $venda->data_venda,
                        'valor' => $venda->valor
                    ];
                })
            ]
        ]);
    }

    public function clienteMaiorFrequenciaCompras()
    {
        $cliente = $this->getClienteMaiorFrequenciaComprasUseCase->execute();
        if (!$cliente) {
            return response()->json(["id" => null, "info" => null, "estatisticas" => null]);
        }
        return response()->json([
            "id" => $cliente->id,
            "info" => [
                "nomeCompleto" => $cliente->nome,
                "detalhes" => [
                    "email" => $cliente->email,
                    "nascimento" => $cliente->data_nascimento
                ]
            ],
            "estatisticas" => [
                "vendas" => $cliente->sales->map(function($venda) {
                    return [
                        'data' => $venda->data_venda,
                        'valor' => $venda->valor
                    ];
                })
            ]
        ]);
    }
}

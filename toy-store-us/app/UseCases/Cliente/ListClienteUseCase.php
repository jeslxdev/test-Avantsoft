<?php

namespace App\UseCases\Cliente;

use App\Repositories\ClienteRepositoryInterface;

class ListClienteUseCase
{
    private $repository;
    public function __construct(ClienteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    public function execute(array $filters)
    {
        $clientes = $this->repository->search($filters);
        $clientesArray = [];
        foreach ($clientes as $cliente) {
            $vendas = $cliente->sales->map(function($venda) {
                return [
                    'data' => $venda->data_venda,
                    'valor' => $venda->valor
                ];
            })->toArray();
            $clienteData = [
                'id' => $cliente->id,
                'info' => [
                    'nomeCompleto' => $cliente->nome,
                    'detalhes' => [
                        'email' => $cliente->email,
                        'nascimento' => $cliente->data_nascimento
                    ]
                ],
                'estatisticas' => [
                    'vendas' => $vendas
                ]
            ];
            $nomeDuplicado = $clientes->where('nome', $cliente->nome)->count() > 1;
            if ($nomeDuplicado) {
                $clienteData['duplicado'] = [
                    'nomeCompleto' => $cliente->nome
                ];
            }
            $clientesArray[] = $clienteData;
        }
        return [
            'data' => [
                'clientes' => $clientesArray
            ],
            'meta' => [
                'registroTotal' => $clientes->count(),
                'pagina' => 1
            ],
            'redundante' => [
                'status' => 'ok'
            ]
        ];
    }
}

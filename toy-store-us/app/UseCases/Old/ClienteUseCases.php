<?php

namespace App\UseCases\Cliente;

use App\Repositories\ClienteRepositoryDatabase;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StoreClienteUseCase
{
    private $repository;
    public function __construct(\App\Repositories\ClienteRepositoryDatabase $repository)
    {
        $this->repository = $repository;
    }
    public function execute(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'razao_social' => 'nullable|string|max:255',
            'nome_fantasia' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:clientes',
            'cpfCnpj' => 'required|string|max:255|unique:clientes',
            'telefone' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'cep' => 'required|string|max:255',
            'pais' => 'required|string|max:255',
            'tipo_cliente' => 'required|string|in:fisica,juridica',
            'data_nascimento' => 'required|date',
        ]);
        return $this->repository->create($validated);
    }
}

class UpdateClienteUseCase
{
    private $repository;
    public function __construct(\App\Repositories\ClienteRepositoryDatabase $repository)
    {
        $this->repository = $repository;
    }
    public function execute(\Illuminate\Http\Request $request, $id)
    {
        $cliente = $this->repository->find($id);
        if (!$cliente) {
            throw \Illuminate\Validation\ValidationException::withMessages(['id' => 'Cliente não encontrado']);
        }
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'razao_social' => 'nullable|string|max:255',
            'nome_fantasia' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:clientes,email,' . $cliente->id,
            'cpfCnpj' => 'required|string|max:255|unique:clientes,cpfCnpj,' . $cliente->id,
            'telefone' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'cep' => 'required|string|max:255',
            'pais' => 'required|string|max:255',
            'tipo_cliente' => 'required|string|in:fisica,juridica',
            'data_nascimento' => 'required|date',
        ]);
        return $this->repository->update($cliente, $validated);
    }
}

class DestroyClienteUseCase
{
    private $repository;
    public function __construct(\App\Repositories\ClienteRepositoryDatabase $repository)
    {
        $this->repository = $repository;
    }
    public function execute($id)
    {
        $cliente = $this->repository->find($id);
        if (!$cliente) {
            throw \Illuminate\Validation\ValidationException::withMessages(['id' => 'Cliente não encontrado']);
        }
        $this->repository->delete($cliente);
        return true;
    }
}

class ListClienteUseCase
{
    private $repository;
    public function __construct(\App\Repositories\ClienteRepositoryDatabase $repository)
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

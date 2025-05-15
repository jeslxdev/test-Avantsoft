<?php

namespace App\UseCases\Cliente;

use App\Repositories\ClienteRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StoreClienteUseCase
{
    private $repository;
    public function __construct(ClienteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    public function execute(Request $request)
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

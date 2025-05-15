<?php

namespace App\UseCases\Cliente;

use App\Repositories\ClienteRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UpdateClienteUseCase
{
    private $repository;
    public function __construct(ClienteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    public function execute(Request $request, $id)
    {
        $cliente = $this->repository->find($id);
        if (!$cliente) {
            throw ValidationException::withMessages(['id' => 'Cliente não encontrado']);
        }
        $rules = [
            'nome' => 'sometimes|string|max:255',
            'razao_social' => 'sometimes|nullable|string|max:255',
            'nome_fantasia' => 'sometimes|nullable|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:clientes,email,' . $cliente->id,
            'cpfCnpj' => 'sometimes|string|max:255|unique:clientes,cpfCnpj,' . $cliente->id,
            'telefone' => 'sometimes|string|max:255',
            'endereco' => 'sometimes|string|max:255',
            'cidade' => 'sometimes|string|max:255',
            'estado' => 'sometimes|string|max:255',
            'cep' => 'sometimes|string|max:255',
            'pais' => 'sometimes|string|max:255',
            'tipo_cliente' => 'sometimes|string|in:fisica,juridica',
            'data_nascimento' => 'sometimes|date',
        ];
        $validated = $request->validate($rules);
        return $this->repository->update($cliente, $validated);
    }
}

<?php

namespace App\Repositories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Collection;

class ClienteRepositoryDatabase implements ClienteRepositoryInterface
{
    public function create(array $data): Cliente
    {
        return Cliente::create($data);
    }

    public function update(Cliente $cliente, array $data): Cliente
    {
        $cliente->update($data);
        return $cliente;
    }

    public function delete(Cliente $cliente): void
    {
        $cliente->delete();
    }

    public function find($id): ?Cliente
    {
        return Cliente::find($id);
    }

    public function search(array $filters): Collection
    {
        $query = Cliente::query();
        if (isset($filters['nome'])) {
            $query->where('nome', 'like', '%' . $filters['nome'] . '%');
        }
        if (isset($filters['email'])) {
            $query->where('email', 'like', '%' . $filters['email'] . '%');
        }
        if (isset($filters['cpfCnpj'])) {
            $query->where('cpfCnpj', 'like', '%' . $filters['cpfCnpj'] . '%');
        }
        return $query->with('sales')->get();
    }
}

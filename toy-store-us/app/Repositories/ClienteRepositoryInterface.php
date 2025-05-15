<?php

namespace App\Repositories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Collection;

interface ClienteRepositoryInterface
{
    public function create(array $data): Cliente;
    public function update(Cliente $cliente, array $data): Cliente;
    public function delete(Cliente $cliente): void;
    public function find($id): ?Cliente;
    public function search(array $filters): Collection;
}
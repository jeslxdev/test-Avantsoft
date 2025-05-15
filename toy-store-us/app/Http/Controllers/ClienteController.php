<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\Cliente\StoreClienteUseCase;
use App\UseCases\Cliente\UpdateClienteUseCase;
use App\UseCases\Cliente\DestroyClienteUseCase;
use App\UseCases\Cliente\ListClienteUseCase;
use App\Repositories\ClienteRepositoryInterface;
use App\Repositories\SaleRepositoryInterface;

class ClienteController extends Controller
{
    private $storeClienteUseCase;
    private $updateClienteUseCase;
    private $destroyClienteUseCase;
    private $listClienteUseCase;
    private $clienteRepository;
    private $saleRepository;

    public function __construct(
        StoreClienteUseCase $storeClienteUseCase,
        UpdateClienteUseCase $updateClienteUseCase,
        DestroyClienteUseCase $destroyClienteUseCase,
        ListClienteUseCase $listClienteUseCase,
        ClienteRepositoryInterface $clienteRepository,
        SaleRepositoryInterface $saleRepository
    ) {
        $this->storeClienteUseCase = $storeClienteUseCase;
        $this->updateClienteUseCase = $updateClienteUseCase;
        $this->destroyClienteUseCase = $destroyClienteUseCase;
        $this->listClienteUseCase = $listClienteUseCase;
        $this->clienteRepository = $clienteRepository;
        $this->saleRepository = $saleRepository;
    }

    public function store(Request $request)
    {
        $cliente = $this->storeClienteUseCase->execute($request);
        return response()->json($cliente, 201);
    }

    public function index(Request $request)
    {
        $response = $this->listClienteUseCase->execute($request->only(['nome', 'email', 'cpfCnpj']));
        return response()->json($response);
    }

    public function update(Request $request, $id)
    {
        $cliente = $this->updateClienteUseCase->execute($request, $id);
        return response()->json($cliente);
    }

    public function destroy($id)
    {
        $this->destroyClienteUseCase->execute($id);
        return response()->json(['message' => 'Cliente deletado com sucesso']);
    }
}


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\SaleController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('clientes', [ClienteController::class, 'store']); // Criar cliente
    Route::get('clientes', [ClienteController::class, 'index']); // Listar clientes
    Route::patch('clientes/{id}', [ClienteController::class, 'update']); // Editar cliente (agora PATCH)
    Route::delete('clientes/{id}', [ClienteController::class, 'destroy']); // Deletar cliente

    Route::post('sales', [SaleController::class, 'store']); // Registrar venda
    Route::get('sales/total-por-dia', [SaleController::class, 'totalVendasPorDia']); // Total de vendas por dia
    Route::get('sales/maior-volume', [SaleController::class, 'clienteMaiorVolumeVendas']); // Cliente com maior volume de vendas
    Route::get('sales/maior-media', [SaleController::class, 'clienteMaiorMediaVendas']); // Cliente com maior média de valor por venda
    Route::get('sales/maior-frequencia', [SaleController::class, 'clienteMaiorFrequenciaCompras']); // Cliente com maior frequência de compras
});

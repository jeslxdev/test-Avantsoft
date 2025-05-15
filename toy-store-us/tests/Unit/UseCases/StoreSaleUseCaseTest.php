<?php

namespace Tests\Unit\UseCases;

use Tests\TestCase;
use App\Models\User;
use App\Models\Cliente;
use Illuminate\Support\Facades\Artisan;

class StoreSaleUseCaseTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
        $this->user = User::factory()->create([
            'password' => bcrypt('password')
        ]);
        $login = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ]);
        $this->token = $login->json('token');
        $this->cliente = Cliente::factory()->create();
    }

    public function test_store_sale_success()
    {
        $payload = [
            'cliente_id' => $this->cliente->id,
            'data_venda' => '2025-05-14',
            'valor' => 100.50,
            'parcelada' => false,
            'metodo_pagamento' => 'cartao',
            'status_venda' => 'concluida',
            'status_pagamento' => 'pagamento confirmado',
        ];
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/sales', $payload);
        $response->assertStatus(201);
    }

    public function test_store_sale_unauthenticated()
    {
        $payload = [
            'cliente_id' => $this->cliente->id,
            'data_venda' => '2025-05-14',
            'valor' => 100.50,
            'parcelada' => false,
            'metodo_pagamento' => 'cartao',
            'status_venda' => 'concluida',
            'status_pagamento' => 'pagamento confirmado',
        ];
        $response = $this->postJson('/api/sales', $payload);
        $response->assertStatus(401);
    }
}

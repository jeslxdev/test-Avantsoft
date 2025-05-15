<?php

namespace Tests\Unit\UseCases;

use Tests\TestCase;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Sale;
use Illuminate\Support\Facades\Artisan;

class GetTotalVendasPorDiaUseCaseTest extends TestCase
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
        Sale::factory()->create([
            'cliente_id' => $this->cliente->id,
            'data_venda' => '2025-05-14',
            'valor' => 100.50,
        ]);
    }

    public function test_get_total_vendas_por_dia_success()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson('/api/sales/total-por-dia');
        $response->assertStatus(200);
        $response->assertJsonStructure(['vendas_por_dia', 'valor_total']);
    }

    public function test_get_total_vendas_por_dia_unauthenticated()
    {
        $response = $this->getJson('/api/sales/total-por-dia');
        $response->assertStatus(401);
    }
}

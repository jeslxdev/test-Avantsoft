<?php

namespace Tests\Unit\UseCases;

use Tests\TestCase;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Sale;
use Illuminate\Support\Facades\Artisan;

class GetClienteMaiorFrequenciaComprasUseCaseTest extends TestCase
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
        ]);
    }

    public function test_get_cliente_maior_frequencia_compras_success()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson('/api/sales/maior-frequencia');
        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'info', 'estatisticas']);
    }

    public function test_get_cliente_maior_frequencia_compras_unauthenticated()
    {
        $response = $this->getJson('/api/sales/maior-frequencia');
        $response->assertStatus(401);
    }
}

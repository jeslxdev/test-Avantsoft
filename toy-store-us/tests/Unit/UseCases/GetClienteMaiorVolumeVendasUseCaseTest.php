<?php

namespace Tests\Unit\UseCases;

use Tests\TestCase;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Sale;
use Illuminate\Support\Facades\Artisan;

class GetClienteMaiorVolumeVendasUseCaseTest extends TestCase
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
            'valor' => 200.00,
        ]);
    }

    public function test_get_cliente_maior_volume_vendas_success()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson('/api/sales/maior-volume');
        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'info', 'estatisticas']);
    }

    public function test_get_cliente_maior_volume_vendas_unauthenticated()
    {
        $response = $this->getJson('/api/sales/maior-volume');
        $response->assertStatus(401);
    }
}

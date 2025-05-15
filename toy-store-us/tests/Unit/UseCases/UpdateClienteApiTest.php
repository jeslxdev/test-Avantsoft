<?php

namespace Tests\Unit\UseCases;

use Tests\TestCase;
use App\Models\User;
use App\Models\Cliente;
use Illuminate\Support\Facades\Artisan;

class UpdateClienteApiTest extends TestCase
{
    protected $user;
    protected $token;

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
    }

    public function test_update_cliente_success()
    {
        // Cria cliente
        $cliente = Cliente::factory()->create([
            'email' => 'cliente@email.com',
            'cpfCnpj' => '12345678900',
        ]);
        $payload = [
            'nome' => 'Cliente Atualizado', // Apenas o campo a ser atualizado
        ];
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->patchJson('/api/clientes/' . $cliente->id, $payload);
        $response->assertStatus(200);
        $response->assertJsonFragment(['nome' => 'Cliente Atualizado']);
    }

    public function test_update_cliente_unauthenticated()
    {
        $cliente = Cliente::factory()->create();
        $payload = [
            'nome' => 'Cliente Atualizado',
        ];
        $response = $this->patchJson('/api/clientes/' . $cliente->id, $payload);
        $response->assertStatus(401);
    }
}

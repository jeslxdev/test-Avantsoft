<?php

namespace Tests\Unit\UseCases;

use Tests\TestCase;
use App\Models\User;
use App\Models\Cliente;
use Illuminate\Support\Facades\Artisan;

class DestroyClienteApiTest extends TestCase
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
    }

    public function test_destroy_cliente_success()
    {
        $cliente = Cliente::factory()->create();
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->deleteJson('/api/clientes/' . $cliente->id);
        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => 'Cliente deletado com sucesso']);
    }

    public function test_destroy_cliente_unauthenticated()
    {
        $cliente = Cliente::factory()->create();
        $response = $this->deleteJson('/api/clientes/' . $cliente->id);
        $response->assertStatus(401);
    }
}

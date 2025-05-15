<?php

namespace Tests\Unit\UseCases;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class StoreClienteApiTest extends TestCase
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

    public function test_create_cliente_success()
    {
        $payload = [
            'nome' => 'Cliente Teste',
            'razao_social' => null,
            'nome_fantasia' => null,
            'email' => 'cliente@email.com',
            'cpfCnpj' => '12345678900',
            'telefone' => '11999999999',
            'endereco' => 'Rua X',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01000-000',
            'pais' => 'Brasil',
            'tipo_cliente' => 'fisica',
            'data_nascimento' => '2000-01-01',
        ];
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/clientes', $payload);
        $response->assertStatus(201);
    }

    public function test_create_cliente_unauthenticated()
    {
        $payload = [
            'nome' => 'Cliente Teste',
            'email' => 'cliente@email.com',
            'cpfCnpj' => '12345678900',
            'telefone' => '11999999999',
            'endereco' => 'Rua X',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01000-000',
            'pais' => 'Brasil',
            'tipo_cliente' => 'fisica',
            'data_nascimento' => '2000-01-01',
        ];
        $response = $this->postJson('/api/clientes', $payload);
        $response->assertStatus(401);
    }
}

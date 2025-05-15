<?php

namespace Tests\Unit\UseCases;

use Tests\TestCase;
use App\Models\User;
use App\Models\Cliente;
use Illuminate\Support\Facades\Artisan;

class ListClienteUseCaseTest extends TestCase
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

    public function test_list_clientes_success()
    {
        Cliente::factory()->count(2)->create();
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson('/api/clientes');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['clientes']]);
    }

    public function test_list_clientes_unauthenticated()
    {
        $response = $this->getJson('/api/clientes');
        $response->assertStatus(401);
    }
}

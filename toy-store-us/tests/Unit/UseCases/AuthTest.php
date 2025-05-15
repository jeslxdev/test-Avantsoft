<?php

namespace Tests\Unit\UseCases;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\JWTAuth;

class AuthTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
    }

    public function test_register_and_login_jwt()
    {
        // Register
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'testuser@email.com',
            'password' => 'password',
        ]);
        $response->assertStatus(201);

        // Login
        $response = $this->postJson('/api/login', [
            'email' => 'testuser@email.com',
            'password' => 'password',
        ]);
        $response->assertStatus(200);
        $token = $response->json('token');
        $this->assertNotEmpty($token);

        // Test authenticated route
        $me = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/me');
        $me->assertStatus(200);
        $me->assertJsonFragment(['email' => 'testuser@email.com']);
    }
}

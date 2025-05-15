<?php

namespace Tests\Unit\UseCases;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class LoginUserUseCaseTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
        $this->user = User::factory()->create([
            'email' => 'loginuser@email.com',
            'password' => bcrypt('password')
        ]);
    }

    public function test_login_success()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'loginuser@email.com',
            'password' => 'password',
        ]);
        $response->assertStatus(200);
        $this->assertNotEmpty($response->json('token'));
    }

    public function test_login_invalid_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'loginuser@email.com',
            'password' => 'wrongpassword',
        ]);
        $response->assertStatus(422)->assertJsonStructure(['message']);
    }
}

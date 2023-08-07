<?php

namespace Tests\Feature\Auth;

use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseTransactions;
    
    public function test_role_superadmin_and_get_token(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/v1/auth/login', [
            'username' => getenv('TEST_USERNAME'),
            'password' => getenv('TEST_PASSWORD'),
        ]);
        $response->assertStatus(201);
    }

    public function test_login_without_username(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/v1/auth/login', [
            'password' => getenv('TEST_PASSWORD'),
        ]);
        $response->assertStatus(404);
    }

    public function test_login_without_password(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/v1/auth/login', [
            'username' => getenv('TEST_USERNAME'),
        ]);
        $response->assertStatus(422);
    }
}
<?php

namespace Tests\Feature\Sector;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListSectors extends TestCase
{
    use DatabaseTransactions;
    public function test_user_role_admin(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                    'username' => config('app_settings.TEST_USERNAME_ADMIN'),
                    'password' => config('app_settings.TEST_PASSWORD_ADMIN')
                ]),
        ])->json('GET', '/api/v1/sectors');

        $response->assertStatus(200);
    }
    public function test_user_role_super_admin(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                    'username' => config('app_settings.TEST_USERNAME'),
                    'password' => config('app_settings.TEST_PASSWORD')
                ]),
        ])->json('GET', '/api/v1/sectors');

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature\Location;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PermissionMunicipalitiesAndCitiesTest extends TestCase
{
    use DatabaseTransactions;

    public function test_cities_user_role_super_admin(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => config('app_settings.TEST_USERNAME'),
                'password' => config('app_settings.TEST_PASSWORD')
            ]),
        ])->json('GET', '/api/v1/cities');
        $response->assertStatus(200);
    }

    public function test_cities_user_role_admin(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                    'username' => config('app_settings.TEST_USERNAME_ADMIN'),
                    'password' => config('app_settings.TEST_PASSWORD_ADMIN')
            ]),
        ])->json('GET', '/api/v1/cities');
        $response->assertStatus(200);
    }

    public function test_cities_user_role_guest(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => "AndresC13",
                'password' => "Test1331",
            ]),
        ])->json('GET', '/api/v1/cities');
        $response->assertStatus(403);
    }

    public function test_municipalities_user_role_super_admin(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => config('app_settings.TEST_USERNAME'),
                'password' => config('app_settings.TEST_PASSWORD')
            ]),
        ])->json('GET', '/api/v1/city/1/municipalities');
        $response->assertStatus(200);
    }

    public function test_municipalities_user_role_admin(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => config('app_settings.TEST_USERNAME_ADMIN'),
                'password' => config('app_settings.TEST_PASSWORD_ADMIN')
            ]),
        ])->json('GET', '/api/v1/city/1/municipalities');
        $response->assertStatus(200);
    }

    public function test_municipalities_user_role_guest(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => "AndresC13",
                'password' => "Test1331",
            ]),
        ])->json('GET', '/api/v1/city/1/municipalities');
        $response->assertStatus(403);
    }
}

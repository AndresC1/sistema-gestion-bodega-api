<?php

namespace Tests\Feature\Organization;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SeeOrganizationTest extends TestCase
{
    public function test_see_organization_user_role_admin(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => config('app_settings.TEST_USERNAME_ADMIN'),
                'password' => config('app_settings.TEST_PASSWORD_ADMIN')
            ]),
        ])->json('GET', '/api/v1/organization_info');

        $response->assertStatus(200);
    }

    public function test_see_organization_user_without_permission(){
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => config('app_settings.TEST_USERNAME'),
                'password' => config('app_settings.TEST_PASSWORD')
            ]),
        ])->json('GET', '/api/v1/organization_info');

        $response->assertStatus(403);
    }
}

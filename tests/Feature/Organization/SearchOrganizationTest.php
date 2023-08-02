<?php

namespace Tests\Feature\Organization;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchOrganizationTest extends TestCase
{
    protected $id_organization = 3;
    public function test_search_organization_role_super_admin(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME'),
                'password' => getenv('TEST_PASSWORD'),
            ]),
        ])->json('GET', '/api/v1/organization/'.$this->id_organization);

        $response->assertStatus(200);
    }
    public function test_search_organization_role_admin(){
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME_ADMIN'),
                'password' => getenv('TEST_PASSWORD_ADMIN'),
            ]),
        ])->json('GET', '/api/v1/organization/'.$this->id_organization);

        $response->assertStatus(403);
    }
}

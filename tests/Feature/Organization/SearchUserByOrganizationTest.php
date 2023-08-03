<?php

namespace Tests\Feature\Organization;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchUserByOrganizationTest extends TestCase
{
    use DatabaseTransactions;

    protected $id_organization = 3;
    
    public function test_user_role_super_admin(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME'),
                'password' => getenv('TEST_PASSWORD'),
            ]),
        ])->json('GET', '/api/v1/organization/'.$this->id_organization.'/users');

        $response->assertStatus(200);
    }

    public function test_user_role_admin(){
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME_ADMIN'),
                'password' => getenv('TEST_PASSWORD_ADMIN'),
            ]),
        ])->json('GET', '/api/v1/organization/'.$this->id_organization.'/users');

        $response->assertStatus(403);
    }
}

<?php

namespace Tests\Feature\Organization;

use App\Models\Organization;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateDataOfMyOrganizationTest extends TestCase
{
    use DatabaseTransactions;

    protected $dataOrganization = [
        'name' => 'New name of organization',
        'ruc' => '12345678901F',
        'address' => 'address of organization',
        'sector_id' => 1,
        'municipality_id' => 30,
        'city_id' => 4,
        'phone_main' => '123456789',
        'phone_secondary' => '1234567890',
    ];

    public function test_update_user_role_admin(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME_ADMIN'),
                'password' => getenv('TEST_PASSWORD_ADMIN'),
            ]),
        ])->json('PATCH', '/api/v1/organization_update', $this->dataOrganization);

        $response->assertStatus(200);
    }

    public function test_update_user_role_super_admin(){
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME'),
                'password' => getenv('TEST_PASSWORD'),
            ]),
        ])->json('PATCH', '/api/v1/organization_update', $this->dataOrganization);

        $response->assertStatus(403);
    }

    public function test_both_data_match(){
        $dataOrganization = Organization::find(1)->get();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME_ADMIN'),
                'password' => getenv('TEST_PASSWORD_ADMIN'),
            ]),
        ])->json('PATCH', '/api/v1/organization_update', [
            'address' => $this->dataOrganization['address'],
            'sector_id' => $dataOrganization[0]->sector_id,
            'municipality_id' => $dataOrganization[0]->municipality_id,
        ]);
        $response->assertStatus(500);
    }
}

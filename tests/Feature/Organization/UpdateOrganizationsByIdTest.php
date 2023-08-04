<?php

namespace Tests\Feature\Organization;

use App\Models\Organization;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateOrganizationsByIdTest extends TestCase
{
    use DatabaseTransactions;

    protected $organizationId = 1;
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

    public function test_update_user_role_super_admin(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME'),
                'password' => getenv('TEST_PASSWORD'),
            ]),
        ])->json('PATCH', '/api/v1/organization/'.$this->organizationId, $this->dataOrganization);

        $organization = Organization::find($this->organizationId)->get();
        $this->assertEquals($this->dataOrganization['name'], $organization[0]->name);
        $this->assertEquals($this->dataOrganization['ruc'], $organization[0]->ruc);
        $this->assertEquals($this->dataOrganization['address'], $organization[0]->address);
        $this->assertEquals($this->dataOrganization['sector_id'], $organization[0]->sector_id);
        $this->assertEquals($this->dataOrganization['municipality_id'], $organization[0]->municipality_id);
        $this->assertEquals($this->dataOrganization['city_id'], $organization[0]->city_id);
        $this->assertEquals($this->dataOrganization['phone_main'], $organization[0]->phone_main);
        $this->assertEquals($this->dataOrganization['phone_secondary'], $organization[0]->phone_secondary);

        $response->assertStatus(200);
    }

    public function test_update_user_role_admin(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME_ADMIN'),
                'password' => getenv('TEST_PASSWORD_ADMIN'),
            ]),
        ])->json('PATCH', '/api/v1/organization/'.$this->organizationId, $this->dataOrganization);

        $response->assertStatus(403);
    }

    public function test_old_name_and_new_name_match(): void
    {
        $organization = Organization::find($this->organizationId)->get();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME'),
                'password' => getenv('TEST_PASSWORD'),
            ]),
        ])->json('PATCH', '/api/v1/organization/'.$this->organizationId, [
            'name' => $organization[0]->name,
            'ruc' => $this->dataOrganization["ruc"],
        ]);
        $response->assertStatus(422);
    }

    public function test_old_data_and_new_data_match(): void
    {
        $organization = Organization::find($this->organizationId)->get();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME'),
                'password' => getenv('TEST_PASSWORD'),
            ]),
        ])->json('PATCH', '/api/v1/organization/'.$this->organizationId, [
            'ruc' => $this->dataOrganization["ruc"],
            'address' => $organization[0]->address,
            'sector_id' => $organization[0]->sector_id,
            'municipality_id' => $organization[0]->municipality_id,
            'city_id' => $organization[0]->city_id,
            'phone_main' => $organization[0]->phone_main,
            'phone_secondary' => $organization[0]->phone_secondary,
        ]);
        $response->assertStatus(422);
    }

    public function test_both_phone_match(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME'),
                'password' => getenv('TEST_PASSWORD'),
            ]),
        ])->json('PATCH', '/api/v1/organization/'.$this->organizationId, [
            'phone_main' => $this->dataOrganization["phone_main"],
            'phone_secondary' => $this->dataOrganization["phone_main"],
        ]);
        
        $response->assertStatus(422);
    }
}

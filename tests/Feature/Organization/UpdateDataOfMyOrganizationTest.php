<?php

namespace Tests\Feature\Organization;

use App\Models\Organization;
use App\Models\User;
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
        'sector_id' => 2,
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
                'username' => config('app_settings.TEST_USERNAME_ADMIN'),
                'password' => config('app_settings.TEST_PASSWORD_ADMIN')
            ]),
        ])->json('PATCH', '/api/v1/organization_update', $this->dataOrganization);

        $response->assertStatus(200);
    }

    public function test_update_user_role_super_admin(){
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => config('app_settings.TEST_USERNAME'),
                'password' => config('app_settings.TEST_PASSWORD')
            ]),
        ])->json('PATCH', '/api/v1/organization_update', $this->dataOrganization);

        $response->assertStatus(403);
    }

    public function test_both_data_match(){
        $data_old_user = User::where('username', config('app_settings.TEST_USERNAME_ADMIN'))->first();
        $data_old_organization = $data_old_user->organization;
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => config('app_settings.TEST_USERNAME_ADMIN'),
                'password' => config('app_settings.TEST_PASSWORD_ADMIN')
            ]),
        ])->json('PATCH', '/api/v1/organization_update', [
            'address' => $this->dataOrganization['address'],
            'sector_id' => $data_old_organization->sector_id,
            'municipality_id' => $data_old_organization->municipality_id,
        ]);
        $data_new_user = User::where('username', config('app_settings.TEST_USERNAME_ADMIN'))->first();
        $data_new_organization = $data_new_user->organization;

        $this->assertEquals($data_old_organization->address, $data_new_organization->address);
        $this->assertEquals($data_old_organization->sector_id, $data_new_organization->sector_id);
        $this->assertEquals($data_old_organization->municipality_id, $data_new_organization->municipality_id);
        $response->assertStatus(500);
    }
}

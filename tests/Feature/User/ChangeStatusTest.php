<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChangeStatusTest extends TestCase
{
    use DatabaseTransactions;

    protected $user_id_super_admin = 2;
    protected $user_id_admin = 3;
    protected $user_id_guest = 4;
    protected $user_id_guest_of_another_organization = 6;

    protected function ValidationChangeStatus(int $id): string{
        $user = User::find($id);
        return $user->status;
    }

    public function test_super_admin_to_an_admin(): void
    {
        $old_status = $this->ValidationChangeStatus($this->user_id_admin);
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => config('app_settings.TEST_USERNAME'),
                'password' => config('app_settings.TEST_PASSWORD')
            ]),
        ])->json('PATCH', '/api/v1/user/'.$this->user_id_admin.'/change_status');

        $response->assertStatus(200);
        $this->assertNotEquals($old_status, $this->ValidationChangeStatus($this->user_id_admin));
    }

    public function test_admin_to_an_guest_of_another_organization(): void
    {
        $old_status = $this->ValidationChangeStatus($this->user_id_guest_of_another_organization);
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => config('app_settings.TEST_USERNAME_ADMIN'),
                'password' => config('app_settings.TEST_PASSWORD_ADMIN')
            ]),
        ])->json('PATCH', '/api/v1/user/'.$this->user_id_guest_of_another_organization.'/change_status');

        $response->assertStatus(403);
        $this->assertEquals($old_status, $this->ValidationChangeStatus($this->user_id_guest_of_another_organization));
    }

    public function test_user_role_super_admin_change_your_own_status(): void
    {
        $old_status = $this->ValidationChangeStatus(1);
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => config('app_settings.TEST_USERNAME'),
                'password' => config('app_settings.TEST_PASSWORD')
            ]),
        ])->json('PATCH', '/api/v1/user/1/change_status');

        $response->assertStatus(200);
        $this->assertNotEquals($old_status, $this->ValidationChangeStatus(1));
    }
    public function test_super_admin_account_active_another_super_admin(){
        $user = User::find($this->user_id_super_admin);
        if($user->status == 'active'){
            $user->status = 'inactive';
            $user->save();
        }
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => config('app_settings.TEST_USERNAME'),
                'password' => config('app_settings.TEST_PASSWORD')
                ]),
        ])->json('PATCH', '/api/v1/user/'.$this->user_id_super_admin.'/change_status');

        $response->assertStatus(200);
        $this->assertEquals('active', $this->ValidationChangeStatus($this->user_id_super_admin));
    }
}

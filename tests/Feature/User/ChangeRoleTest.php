<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChangeRoleTest extends TestCase
{
    use DatabaseTransactions;

    protected $id_user_super_admin = 2;
    protected $id_user_admin = 2;
    protected $id_user_different_organization = 6;
    protected $id_user_guest = 3;

    public function test_user_role_super_admin_create_user_super_admin(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => config('app_settings.TEST_USERNAME'),
                'password' => config('app_settings.TEST_PASSWORD')
            ]),
        ])->json('POST', '/api/v1/user/change_role', [
            'user_id' => $this->id_user_admin,
            'role_id' => 1,
        ]);
        $user = User::find($this->id_user_admin);
        $response->assertStatus(403);
        $this->assertNotEquals(1, $user->role_id);
    }

    public function test_from_different_organization(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => config('app_settings.TEST_USERNAME_ADMIN'),
                'password' => config('app_settings.TEST_PASSWORD_ADMIN')
            ]),
        ])->json('POST', '/api/v1/user/change_role', [
            'user_id' => $this->id_user_different_organization,
            'role_id' => 3,
        ]);
        $user = User::find($this->id_user_admin);
        $response->assertStatus(403);
        $this->assertNotEquals(3, $user->role_id);
    }
}

<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use DatabaseTransactions;

    protected $data_new_user = [
        'name' => 'test new user',
        'email' => 'example20@test.com',
        'username' => 'new_user',
        'role_id' => '2',
        'organization_id' => '1',
    ];

    public function test_create_user_in_organization(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME'),
                'password' => getenv('TEST_PASSWORD'),
            ]),
        ])->json('POST', '/api/v1/auth/register', $this->data_new_user);

        $usuario = User::where('username', $this->data_new_user['username'])->get();
        $this->assertNotEmpty($usuario);
        $this->assertEquals($usuario[0]->name, $this->data_new_user['name']);
        $this->assertEquals($usuario[0]->email, $this->data_new_user['email']);
        $this->assertEquals($usuario[0]->username, $this->data_new_user['username']);
        $this->assertEquals($usuario[0]->role_id, $this->data_new_user['role_id']);
        $this->assertEquals($usuario[0]->organization_id, $this->data_new_user['organization_id']);
        $response->assertStatus(201);
    }

    public function test_create_user_send_id_organization_with_user_role_admin(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME_ADMIN'),
                'password' => getenv('TEST_PASSWORD_ADMIN'),
            ]),
        ])->json('POST', '/api/v1/auth/register', $this->data_new_user);

        $usuario = User::where('username', $this->data_new_user['username'])->get();
        $this->assertEmpty($usuario);
        $response->assertStatus(422);
    }

    public function test_create_user_in_my_organization_with_user_role_admin(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME_ADMIN'),
                'password' => getenv('TEST_PASSWORD_ADMIN'),
            ]),
        ])->json('POST', '/api/v1/auth/register', [
            'name' => $this->data_new_user['name'],
            'email' => $this->data_new_user['email'],
            'username' => $this->data_new_user['username'],
            'role_id' => $this->data_new_user['role_id'],
            'organization_id' => 3,
        ]);

        $usuario = User::where('username', $this->data_new_user['username'])->get();
        $this->assertNotEmpty($usuario);
        $this->assertEquals($usuario[0]->name, $this->data_new_user['name']);
        $this->assertEquals($usuario[0]->email, $this->data_new_user['email']);
        $this->assertEquals($usuario[0]->username, $this->data_new_user['username']);
        $this->assertEquals($usuario[0]->role_id, $this->data_new_user['role_id']);
        $this->assertEquals($usuario[0]->organization_id, 3);
        $response->assertStatus(201);
    }

    public function test_create_user_with_role_admin_user_super_admin(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME_ADMIN'),
                'password' => getenv('TEST_PASSWORD_ADMIN'),
            ]),
        ])->json('POST', '/api/v1/auth/register', [
            'name' => $this->data_new_user['name'],
            'email' => $this->data_new_user['email'],
            'username' => $this->data_new_user['username'],
            'role_id' => 1,
            'organization_id' => 3,
        ]);
        $usuario = User::where('username', $this->data_new_user['username'])->get();
        $this->assertEmpty($usuario);
        $response->assertStatus(422);
    }

    public function test_create_user_with_role_super_admin_user_super_admin(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME'),
                'password' => getenv('TEST_PASSWORD'),
            ]),
        ])->json('POST', '/api/v1/auth/register', [
            'name' => $this->data_new_user['name'],
            'email' => $this->data_new_user['email'],
            'username' => $this->data_new_user['username'],
            'role_id' => 1,
            'organization_id' => $this->data_new_user['organization_id'],
        ]);

        $usuario = User::where('username', $this->data_new_user['username'])->get();
        $this->assertNotEmpty($usuario);
        $this->assertEquals($usuario[0]->name, $this->data_new_user['name']);
        $this->assertEquals($usuario[0]->email, $this->data_new_user['email']);
        $this->assertEquals($usuario[0]->username, $this->data_new_user['username']);
        $this->assertEquals($usuario[0]->role_id, 1);
        $this->assertEquals($usuario[0]->organization_id, $this->data_new_user['organization_id']);
        $response->assertStatus(201);
    }
}

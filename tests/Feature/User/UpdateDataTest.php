<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateDataTest extends TestCase
{
    use DatabaseTransactions;

    protected $new_email = "example2@test.com";
    protected $new_name = "nombre de prueba";

    public function test_update_data_user(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME'),
                'password' => getenv('TEST_PASSWORD'),
            ]),
        ])->json('PATCH', '/api/v1/user', [
            'name' => $this->new_name,
            'email' => $this->new_email,
        ]);
        $user = User::where('username', getenv('TEST_USERNAME'))->first();
        $this->assertEquals($this->new_name, $user->name);
        $this->assertEquals($this->new_email, $user->email);

        $response->assertStatus(200);
    }

    public function test_match_old_email(){
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME'),
                'password' => getenv('TEST_PASSWORD'),
            ]),
        ])->json('PATCH', '/api/v1/user', [
            'name' => $this->new_name,
            'email' => getenv('TEST_EMAIL'),
        ]);
        $response->assertStatus(422);
    }

    public function test_update_email_user(){
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME'),
                'password' => getenv('TEST_PASSWORD'),
            ]),
        ])->json('PATCH', '/api/v1/user', [
            'email' => $this->new_email,
        ]);
        $user = User::where('username', getenv('TEST_USERNAME'))->first();
        $this->assertEquals($this->new_email, $user->email);
        $response->assertStatus(200);
    }

    public function test_update_name_user(){
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME'),
                'password' => getenv('TEST_PASSWORD'),
            ]),
        ])->json('PATCH', '/api/v1/user', [
            'name' => $this->new_name,
        ]);
        $user = User::where('username', getenv('TEST_USERNAME'))->first();
        $this->assertEquals($this->new_name, $user->name);
        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    use DatabaseTransactions;

    protected $new_password = "prueba1234";

    public function test_change_password_user(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME'),
                'password' => getenv('TEST_PASSWORD'),
            ]),
        ])->json('POST', '/api/v1/user/change_password', [
            'password' => $this->new_password,
            'old_password' => getenv('TEST_PASSWORD'),
        ]);
        $user = User::where('username', getenv('TEST_USERNAME'))->first();
        $this->assertTrue(Hash::check($this->new_password, $user->password));
        $this->assertEquals(1, $user->verification_password);
        $response->assertStatus(200);
    }

    public function test_both_passwords_match(){
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME'),
                'password' => getenv('TEST_PASSWORD'),
            ]),
        ])->json('POST', '/api/v1/user/change_password', [
            'password' => getenv('TEST_PASSWORD'),
            'old_password' => getenv('TEST_PASSWORD'),
        ]);
        $response->assertStatus(422);
    }

    public function test_old_password_different(){
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->getTokenUser([
                'username' => getenv('TEST_USERNAME'),
                'password' => getenv('TEST_PASSWORD'),
            ]),
        ])->json('POST', '/api/v1/user/change_password', [
            'password' => $this->new_password,
            'old_password' => "passwordDifferent",
        ]);
        $response->assertStatus(422);
    }
}

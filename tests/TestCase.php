<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getTokenUser($dataUser){
        $user = $this->withHeaders([
            'Accept' => 'application/json'
        ])->json('POST', '/api/v1/auth/login', [
            'username' => $dataUser["username"],
            'password' => $dataUser["password"],
        ]);
        return $user->json('token');
    }
}

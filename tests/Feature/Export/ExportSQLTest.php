<?php

namespace Tests\Feature\Export;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ExportSQLTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * @test
     */
    public function export_data_for_organization_of_type_sql(): void
    {
        $user = UserFactory::new()->create();
        $user->role_id = 2; // rol admin
        $this->actingAs($user);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('GET', '/api/v1/export_sql/'.$user->organization_id);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/sql');
    }

    /**
     * @test
     */
    public function export_data_global_of_type_sql(): void
    {
        $user = UserFactory::new()->create();
        $user->role_id = 1; // rol super admin
        $user->organization_id = null;
        $this->actingAs($user);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('GET', '/api/v1/export_sql');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/sql');
    }

    /**
     * @test
     */
    public function export_data_for_organization_of_type_sql_with_user_not_admin(): void
    {
        $user = UserFactory::new()->create();
        $user->role_id = 3; // rol guest
        $this->actingAs($user);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('GET', '/api/v1/export_sql/'.$user->organization_id);

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function export_data_global_of_type_sql_with_user_not_super_admin(): void
    {
        $user = UserFactory::new()->create();
        $user->role_id = 2; // rol admin
        $user->organization_id = null;
        $this->actingAs($user);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('GET', '/api/v1/export_sql');

        $response->assertStatus(403);
    }
}

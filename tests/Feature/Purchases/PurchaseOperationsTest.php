<?php

namespace Tests\Feature\Purchases;

use Database\Factories\InventoryFactory;
use Database\Factories\OrganizationFactory;
use Database\Factories\ProviderFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PurchaseOperationsTest extends TestCase
{
    use DatabaseTransactions;

    protected $organization;
    protected $provider;
    protected $user;
    protected $inventories_of_organization;
    protected $inventory_out_of_organization;
    protected $purchases;
    protected $purchase_invalid;
    protected $data_of_purchase;
    protected $purchase_id;

    public function setUp(): void
    {
        parent::setUp();
        // organization
        $this->organization = OrganizationFactory::new()->create();
        // provider
        $this->provider = ProviderFactory::new()->create([
            "organization_id" => $this->organization->id
        ]);
        // inventories of organization
        $this->inventories_of_organization = InventoryFactory::new()->count(4)->create([
            "type" => "MP",
            "organization_id" => $this->organization->id
        ]);
        // inventory out of organization
        $this->inventory_out_of_organization = InventoryFactory::new()->create();
        // list of purchases
        $this->purchases = $this->inventories_of_organization->map(function($inventory){
            return [
                "product_id" => $inventory->product_id,
                "quantity" => 1,
                "price" => 100,
                "observation" => "test",
            ];
        });
        // purchase invalid
        $this->purchase_invalid = [[
            "product_id" => $this->inventory_out_of_organization->product_id,
            "quantity" => 1,
            "price" => 100,
            "observation" => "test",
        ]];
        // data of purchase
        $this->data_of_purchase = "?number_bill=Test-0001&provider_id=".$this->provider->id;
        // user
        $this->user = UserFactory::new()->create([
            "organization_id" => $this->organization->id,
            "role_id" => 2
        ]);
        // login
        $this->actingAs($this->user);
    }

    /** @test **/
    public function validate_data_in_table_purchases(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/v1/purchase'.$this->data_of_purchase, $this->purchases->toArray());
        // validate response
        $response->assertStatus(200);
        // validate database purchase
        $this->assertDatabaseHas('purchases', [
            "number_bill" => "Test-0001",
            "organization_id" => $this->organization->id,
            "provider_id" => $this->provider->id,
            "user_id" => $this->user->id,
            "date" => now("America/Managua")->format('Y-m-d'),
            "total" => 400,
        ]);
    }

    /** @test **/
    public function validate_data_in_the_table_inventories(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/v1/purchase'.$this->data_of_purchase, $this->purchases->toArray());
        // validate response
        $response->assertStatus(200);
        // validate database inventory
        $this->inventories_of_organization->each(function($inventory){
            $this->assertDatabaseHas('inventories', [
                "product_id" => $inventory->product_id,
                "organization_id" => $this->organization->id,
                "stock" => $inventory->stock + 1,
                "total_value" => $inventory->total_value + 100,
            ]);
        });
    }

    /** @test **/
    public function validate_data_in_the_table_details_purchases(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/v1/purchase'.$this->data_of_purchase, $this->purchases->toArray());
        // validate response
        $response->assertStatus(200);
        // get purchase id
        $responseData = json_decode($response->getContent(), true);
        $this->purchase_id = $responseData['purchase']['id'];
        // validate database details purchase
        $this->inventories_of_organization->each(function($inventory){
            $this->assertDatabaseHas('details_purchases', [
                "organization_id" => $this->organization->id,
                "purchase_id" => $this->purchase_id,
                "product_id" => $inventory->product_id,
                "quantity" => 1,
                "price" => 100,
                "total" => 100,
                "disponibility" => 1,
                "observation" => "test",
            ]);
        });
    }

    /** @test **/
    public function inventory_out_of_organization_not_be_updated(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/v1/purchase'.$this->data_of_purchase, $this->purchase_invalid);
        // validate response
        $response->assertStatus(422);
    }
}

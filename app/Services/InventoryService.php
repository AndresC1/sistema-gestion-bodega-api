<?php

namespace App\Services;

use App\Models\Inventory;
use App\Repository\InventoryRepository;

class InventoryService
{
    private $inventoryRepository;

    public function __construct()
    {
        $this->inventoryRepository = new InventoryRepository();
    }
    public function update_increase($inventory, $quantity, $total_value)
    {
        $this->inventoryRepository->update_increase($inventory, $quantity, $total_value);
    }
    public function update_decrease($inventory, $quantity, $total_value)
    {
        $this->inventoryRepository->update_decrease($inventory, $quantity, $total_value);
    }
    public function search_inventory_MP($product_id){
        return $this->inventoryRepository->search_inventory_MP($product_id);
    }
}

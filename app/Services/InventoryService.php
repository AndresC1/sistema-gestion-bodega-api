<?php

namespace App\Services;

use App\Models\Inventory;
use App\Repository\InventoryRepository;

class InventoryService
{
    private $inventoryRepository;

    public function __construct(InventoryRepository $inventoryRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
    }
    public function update($inventory, $quantity, $total_value)
    {
//        $inventory = Inventory::find($inventory->id);
        $this->inventoryRepository->update($inventory, $quantity, $total_value);
    }
}

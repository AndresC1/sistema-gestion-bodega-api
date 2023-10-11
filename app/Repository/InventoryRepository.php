<?php

namespace App\Repository;

use App\Models\Inventory;

class InventoryRepository
{
    public function update_increase($inventory, $quantity, $total_value)
    {
        $stock = $inventory->stock + $quantity;
        $totalValue = $inventory->total_value + $total_value;
        $inventory->update([
            'stock' => $stock,
            'total_value' => $totalValue,
            'status' => $stock > 0 ? 'Disponible' : 'No Disponible',
            'date_last_modified' => now('America/Managua'),
        ]);
    }
    public function update_decrease($inventory, $quantity, $total_value){
        $stock = $inventory->stock - $quantity;
        $totalValue = $inventory->total_value - $total_value;
        $inventory->update([
            'stock' => $stock,
            'total_value' => $totalValue,
            'status' => $stock > 0 ? 'Disponible' : 'No Disponible',
            'date_last_modified' => now('America/Managua'),
        ]);
    }
    public function search_inventory_MP($product_id){
        return auth()->user()->organization->inventories
            ->where('product_id', $product_id)
            ->where('type', 'MP')
            ->first();
    }
}

<?php

namespace App\Repository;

use App\Models\Inventory;

class InventoryRepository
{
    public function update($inventory, $quantity, $total_value)
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
}

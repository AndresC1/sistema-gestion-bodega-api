<?php

namespace App\Repository;

use App\Models\OutputsProduct;
use DateTime;

class OutputProductRepository
{
    public function create($data)
    {
        $outputProduct = OutputsProduct::create([
            'inventory_id' => $data['inventory_id'],
            'organization_id' => auth()->user()->organization->id,
            'user_id' => auth()->user()->id,
            'date' => now('America/Managua')->format('Y-m-d'),
            'quantity' => $data['quantity'],
            'price' => $data['price'],
            'total' => $data['total'],
            'observation' => $data['observation'],
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        return $outputProduct->id;
    }
}

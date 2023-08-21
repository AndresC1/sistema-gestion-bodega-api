<?php

namespace App\Services;

use App\Models\ProductInput;
use App\Repository\EntryProductRepository;
use DateTime;

class EntryProductService
{
    private $entryProductRepository;

    public function __construct(EntryProductRepository $entryProductRepository)
    {
        $this->entryProductRepository = $entryProductRepository;
    }
    public function store($inventory_id, $quantity, $price, $total, $observation)
    {
        $this->entryProductRepository->create([
            'inventory_id' => $inventory_id,
            'organization_id' => auth()->user()->organization->id,
            'user_id' => auth()->user()->id,
            'date' => now('America/Managua'),
            'quantity' => $quantity,
            'price' => $price,
            'total' => $total,
            'observation' => $observation,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}

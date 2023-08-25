<?php

namespace App\Services;

use DateTime;
use App\Repository\DetailsEntryProductRepository;

class DetailsEntryProductService
{
    private $detailsEntryProductRepository;

    public function __construct()
    {
        $this->detailsEntryProductRepository = new DetailsEntryProductRepository();
    }

    public function store($entry_product_id, $detail_purchase_id, $quantity, $price)
    {
        $this->detailsEntryProductRepository->create([
            'details_purchase_id' => $detail_purchase_id,
            'product_input_id' => $entry_product_id,
            'quantity' => $quantity,
            'price' => $price,
            'total' => $quantity * $price,
            'description' => 'Registro de producto terminado el ' . now('America/Managua')->format('d/m/Y'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}

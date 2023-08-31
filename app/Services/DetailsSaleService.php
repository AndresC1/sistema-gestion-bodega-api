<?php

namespace App\Services;

use App\Models\ProductInput;
use App\Repository\DetailsSaleRepository;

class DetailsSaleService
{
    private $detailsSaleRepository;
    public function __construct()
    {
        $this->detailsSaleRepository = new DetailsSaleRepository();
    }
    public function store($saleId, $data)
    {
        $productInput = ProductInput::find($data["product_input_id"]);
        $costTotal = $productInput->price * $data["quantity"];
        $saleTotal = $data["quantity"] * $data["price"];
        $this->detailsSaleRepository->store([
            'sale_id' => $saleId,
            'product_input_id' => $productInput->id,
            'organization_id' => auth()->user()->organization_id,
            'quantity' => $data['quantity'],
            'price' => $data['price'],
            'total' => $saleTotal,
            'cost_unit' => $productInput->price,
            'cost_total' => $costTotal,
            'earning' => $saleTotal - $costTotal,
            'created_at' => now('America/Managua'),
            'updated_at' => now('America/Managua'),
        ]);
    }
}

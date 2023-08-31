<?php

namespace App\Services;

use App\Models\DetailsPurchase;
use App\Models\Inventory;
use App\Services\DetailsPurchaseService;
use App\Services\InventoryService;
use App\Repository\OutputProductRepository;

class OutputProductService
{
    private $outputProductRepository;
    private $detailsPurchaseService;
    private $inventoryService;

    public function __construct() {
        $this->outputProductRepository = new OutputProductRepository();
    }
    public function store($data){
        $this->outputProductRepository->create([
            'inventory_id' => $data['inventory_id'],
            'quantity' => $data['quantity'],
            'total' => $data['total'],
            'price' => $data['price'],
            'observation' => $data['observation'],
        ]);
    }

    public function Register($detail_purchase_id, $quantity, $total, $product_id, $price){
        $this->detailsPurchaseService = new DetailsPurchaseService();
        $this->inventoryService = new InventoryService();

        $inventory = Inventory::where('product_id', $product_id)
            ->where('organization_id', auth()->user()->organization->id)
            ->first();
        $this->detailsPurchaseService->update_disponibility($detail_purchase_id, $quantity);
        $this->store([
            'inventory_id' => $inventory->id,
            'quantity' => $quantity,
            'total' => $total,
            'price' => $price,
            'observation' => "Salida de producto el " . now('America/Managua')->format('d/m/Y')." por produccion.",
        ]);
        $this->inventoryService->update_decrease($inventory, $quantity, $total);
    }
}

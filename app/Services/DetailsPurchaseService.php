<?php

namespace App\Services;

use App\Models\DetailsPurchase;
use App\Repository\DetailsPurchaseRepository;
use DateTime;

class DetailsPurchaseService
{
    protected $purchaseRepository;
    protected $EntryProductService;
    protected $InventoryService;

    public function __construct(){
        $this->purchaseRepository = new DetailsPurchaseRepository();
        $this->EntryProductService = new EntryProductService();
        $this->InventoryService = new InventoryService();
    }
    public function createDetailsPurchase($data){
        foreach ($data['listDetailsPurchase'] as $detailPurchase){
            $inventory = $this->InventoryService->search_inventory_MP($detailPurchase['product_id']);
            $total = $detailPurchase['quantity'] * $detailPurchase['price'];
            // creacion de detalle de compra
            $this->store($data['purchase_id'], $inventory->product_id, $detailPurchase);
            // creacion de entrada de producto
            $this->EntryProductService->store(
                $inventory->id,
                $detailPurchase['quantity'],
                $detailPurchase['price'],
                $total,
                "Compra de materia prima a proveedor ".$data['provider'].". Fact No.".$data['number_bill']." el ".now('America/Managua')->format('d-m-Y').".",
                $detailPurchase['quantity']
            );
            // actualizacion de inventario
            $this->InventoryService->update_increase(
                $inventory,
                $detailPurchase['quantity'],
                $total,
            );
        }
    }
    protected function store($purchase_id, $product_id, $detailPurchase){
        $this->purchaseRepository->create([
            'organization_id' => auth()->user()->organization_id,
            'purchase_id' => $purchase_id,
            'product_id' => $product_id,
            'quantity' => $detailPurchase['quantity'],
            'price' => $detailPurchase['price'],
            'total' => $detailPurchase['quantity'] * $detailPurchase['price'],
            'disponibility' => $detailPurchase['quantity'],
            'observation' => $detailPurchase['observation']??null,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
    public function update_disponibility($detailPurchase_id, $quantity){
        $detailPurchase = DetailsPurchase::find($detailPurchase_id);
        $detailPurchase->disponibility -= $quantity;
        $this->purchaseRepository->update($detailPurchase->toArray(), $detailPurchase_id);
    }
}

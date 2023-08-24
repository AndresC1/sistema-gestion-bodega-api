<?php

namespace App\Services;

use App\Models\DetailsPurchase;
use App\Repository\DetailsPurchaseRepository;
use App\Rules\Purchase\ValidateTypeProduct;
use Illuminate\Http\Request;
use Exception;
use DateTime;
use Illuminate\Support\Facades\Validator;

class DetailsPurchaseService
{
    protected $purchaseRepository;
    protected $EntryProductService;
    protected $InventoryService;

    public function __construct(
        DetailsPurchaseRepository $purchaseRepository,
        EntryProductService       $EntryProductService,
        InventoryService          $InventoryService
    ){
        $this->purchaseRepository = $purchaseRepository;
        $this->EntryProductService = $EntryProductService;
        $this->InventoryService = $InventoryService;
    }
    public function createDetailsPurchase($data){
        foreach ($data['listDetailsPurchase'] as $detailPurchase){
            $inventory = $this->searchInventory($detailPurchase['product_id']);
            $total = $this->total($detailPurchase['quantity'], $detailPurchase['price']);
            // creacion de detalle de compra
            $this->store($data['purchase_id'], $inventory->product_id, $detailPurchase);
            // creacion de entrada de producto
            $this->createEntryProduct(
                $inventory->id,
                $detailPurchase['quantity'],
                $detailPurchase['price'],
                $total,
                "Compra de materia prima a proveedor ".$data['provider'].". Fact No.".$data['number_bill']." el ".now('America/Managua')->format('d-m-Y')."."
            );
            // actualizacion de inventario
            $this->updateInventory($inventory, $detailPurchase['quantity'], $total);
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
    protected function searchInventory($product_id){
        return auth()->user()->organization->inventories
            ->where('product_id', $product_id)
            ->where('type', 'MP')
            ->first();
    }
    protected function updateInventory($inventory, $quantity, $total){
        $this->InventoryService->update(
            $inventory,
            $quantity,
            $total,
        );
    }
    protected function createEntryProduct($inventory_id, $quantity, $price, $total, $observation){
        $this->EntryProductService->store(
            $inventory_id,
            $quantity,
            $price,
            $total,
            $observation
        );
    }
    protected function total($quantity, $price){
        return $quantity * $price;
    }

    public function ValidateData($data_detailsPurchase){
        $validator_listDetailsPurchase = Validator::make($data_detailsPurchase, [
            '*.product_id' => [
                'required',
                'numeric',
                'min:1',
                'exists:products,id',
                new ValidateTypeProduct()
            ],
            '*.quantity' => 'required|numeric|min:1',
            '*.price' => 'required|numeric|min:0',
            '*.observation' => 'nullable|string',
        ]);
        if ($validator_listDetailsPurchase->fails()) {
            return $validator_listDetailsPurchase->errors();
        }
        $validator_listDetailsPurchase->validate();
        return null;
    }
}

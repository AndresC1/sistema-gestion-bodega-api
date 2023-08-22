<?php

namespace App\Services;

use App\Models\DetailsPurchase;
use App\Models\Inventory;
use App\Repository\EntryProductRepository;
use App\Rules\ProductInput\ValidateDetailsPurchaseExistInTheOrganization;
use App\Services\DetailsEntryProductService;
use App\Services\InventoryService;
use Exception;
use DateTime;
use Illuminate\Support\Facades\Validator;

class EntryProductService
{
    private $entryProductRepository;
    private $detailsEntryProductService;
    private $inventoryService;

    public function __construct(
        EntryProductRepository $entryProductRepository,
        DetailsEntryProductService $detailsEntryProductService,
        InventoryService $inventoryService
    ){
        $this->entryProductRepository = $entryProductRepository;
        $this->detailsEntryProductService = $detailsEntryProductService;
        $this->inventoryService = $inventoryService;
    }
    public function store($inventory_id, $quantity, $price, $total, $observation)
    {
        $EntryProductId = $this->entryProductRepository->create([
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
        return $EntryProductId;
    }

    public function insertProductInput($request, $dataEntryProduct){
        $total = 0;
        $detailsEntryProduct = [];
        foreach ($dataEntryProduct as $entryProduct) {
            $detailPurchase = DetailsPurchase::find($entryProduct['detail_purchase_id'])->first();
            $detailsEntryProduct[] = [
                $entryProduct['detail_purchase_id'],
                $entryProduct['quantity'],
                $detailPurchase->price
            ];
            $total += $entryProduct['quantity'] * $detailPurchase->price;
        }
        $dataEntryProduct = $this->store(
            $request->inventory_id,
            $request->quantity,
            $total / $request->quantity,
            $total,
            "Registro de producto terminado el " . now('America/Managua')->format('d/m/Y')
        );
        foreach ($detailsEntryProduct as $entryProduct) {
            $this->detailsEntryProductService->store(
                $dataEntryProduct,
                $entryProduct[0],
                $entryProduct[1],
                $entryProduct[2]
            );
        }
        $this->inventoryService->update(
            Inventory::find($request->inventory_id),
            $request->quantity,
            $total
        );
        return $dataEntryProduct;
    }

    public function Validate($dataEntryProduct){
        $validator_productInput = Validator::make($dataEntryProduct, [
            '*.detail_purchase_id' => [
                'required',
                'numeric',
                'min:1',
                'exists:details_purchases,id',
                new ValidateDetailsPurchaseExistInTheOrganization()
            ],
            '*.quantity' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($dataEntryProduct) {
                    $this->ValidateDisponibility($dataEntryProduct, $attribute, $value);
                }
            ],
            '*.observation' => 'nullable|string|max:255',
        ]);
        if ($validator_productInput->fails()) {
            return $validator_productInput->errors();
        }
        $validator_productInput->validate();
        return null;
    }
    private function ValidateDisponibility($dataEntryProduct, $attribute, $value){
        $detailPurchaseId = $dataEntryProduct[$attribute[0]]['detail_purchase_id'];
        $detailPurchase = DetailsPurchase::find($detailPurchaseId);
        if ($value > $detailPurchase->disponibility) {
            throw new Exception("La cantidad ingresada es mayor a la cantidad que dispone en la compra.");
        }
    }
}

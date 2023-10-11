<?php

namespace App\Services;

use App\Repository\PurchaseRepository;
use App\Rules\Purchase\ValidateTypeProduct;
use Illuminate\Support\Facades\Validator;

class PurchaseService
{
    private $purchaseRepository;
    private $detailsPurchaseService;
    private $purchase_new;

    public function __construct(){
        $this->purchaseRepository = new PurchaseRepository();
    }
    public function create($request)
    {
        $this->purchase_new = $this->purchaseRepository->create($request);
        return $this->purchase_new;
    }
    public function insertDetailsPurchase($request)
    {
        $data_detailsPurchase = $request->json()->all();
        $this->detailsPurchaseService = new DetailsPurchaseService();
        $this->detailsPurchaseService->createDetailsPurchase([
            'purchase_id' => $this->purchase_new->id,
            'listDetailsPurchase' => $data_detailsPurchase,
            'provider' => $this->purchase_new->provider->name,
            'number_bill' => $request->number_bill
        ]);
    }
    public function validate_details_purchase($data_detailsPurchase){
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
    public function register($request){
        // Crear compra
        $purchase_new = $this->create($request);
        // Crear detalles de compra, entrada y actualizacion en el inventario
        $this->insertDetailsPurchase($request);
        return $purchase_new;
    }
}

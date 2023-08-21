<?php

namespace App\Services;

use App\Repository\PurchaseRepository;

class PurchaseService
{
    private $purchaseRepository;
    private $detailsPurchaseService;
    private $purchase_new;

    public function __construct(
        PurchaseRepository $purchaseRepository,
        DetailsPurchaseService $detailsPurchaseService
    ){
        $this->purchaseRepository = $purchaseRepository;
        $this->detailsPurchaseService = $detailsPurchaseService;
    }
    public function create($request)
    {
        $this->purchase_new = $this->purchaseRepository->create($request);
        return $this->purchase_new;
    }
    public function insertDetailsPurchase($data_detailsPurchase, $request)
    {
        $this->detailsPurchaseService->createDetailsPurchase([
            'purchase_id' => $this->purchase_new->id,
            'listDetailsPurchase' => $data_detailsPurchase,
            'provider' => $this->purchase_new->provider->name,
            'number_bill' => $request->number_bill
        ]);
    }
}

<?php

namespace App\Repository;

use App\Models\Purchase;

class PurchaseRepository
{
    protected $sumTotal;
    public function create($request)
    {
        $this->sumTotal($request->json()->all());
        return Purchase::create([
            'number_bill' => $request->number_bill,
            'provider_id' => $request->provider_id,
            'user_id' => auth()->user()->id,
            'organization_id' => auth()->user()->organization_id,
            'date' => now('America/Managua'),
            'total' => $this->sumTotal,
        ]);
    }
    protected function sumTotal($data)
    {
        foreach ($data as $detailPurchase) {
            $this->sumTotal += $detailPurchase['quantity'] * $detailPurchase['price'];
        }
    }
}

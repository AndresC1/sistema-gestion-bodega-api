<?php

namespace App\Repository;

use App\Models\DetailsPurchase;

class DetailsPurchaseRepository
{
    public function create($data)
    {
        $purchase = new DetailsPurchase();
        $purchase->fill($data);
        $purchase->save();
    }
    public function update($data, $id)
    {
        $purchase = DetailsPurchase::find($id);
        $purchase->fill($data);
        $purchase->save();
    }
}

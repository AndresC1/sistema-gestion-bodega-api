<?php

namespace App\Repository;

use App\Models\Sale;

class SaleRepository
{
    public function store($data)
    {
        $sale = new Sale();
        $sale->fill($data);
        $sale->save();
        return $sale;
    }
    public function update($sale, $total, $earning_total)
    {
        $sale->total = $total;
        $sale->earning_total = $earning_total;
        $sale->save();
    }
}

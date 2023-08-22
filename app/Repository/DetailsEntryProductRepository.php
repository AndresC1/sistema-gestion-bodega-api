<?php

namespace App\Repository;

use App\Models\DetailsProductInput;

class DetailsEntryProductRepository
{
    public function create($data)
    {
        $detailsEntryProduct = new DetailsProductInput();
        $detailsEntryProduct->fill($data);
        $detailsEntryProduct->save();
    }
}

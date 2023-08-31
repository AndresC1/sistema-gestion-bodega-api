<?php

namespace App\Repository;

use App\Models\DetailsSale;

class DetailsSaleRepository
{
    public function store($data)
    {
        $detailsSale = new DetailsSale();
        $detailsSale->fill($data);
        $detailsSale->save();
        return $detailsSale;
    }
}

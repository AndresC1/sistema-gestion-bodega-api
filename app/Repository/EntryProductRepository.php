<?php

namespace App\Repository;

use App\Models\ProductInput;

class EntryProductRepository
{
    public function create($data)
    {
        $entry = new ProductInput();
        $entry->fill($data);
        $entry->save();
        return $entry->id;
    }
    public function update(ProductInput $entry, $quantity)
    {
        $entry->disponibility = $entry->disponibility - $quantity;
        $entry->save();
        return $entry;
    }
}

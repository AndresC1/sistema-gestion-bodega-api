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
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'measurement_type'
    ];

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'product_id');
    }

    public function detailsPurchase()
    {
        return $this->hasMany(DetailsPurchase::class, 'product_id');
    }
}

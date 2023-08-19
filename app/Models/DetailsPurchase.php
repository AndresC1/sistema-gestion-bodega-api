<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'product_id',
        'quantity',
        'price',
        'total',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productInputs()
    {
        return $this->hasMany(ProductInput::class, 'details_purchase_id');
    }

    public function detailsProductInputs()
    {
        return $this->hasMany(DetailsProductInput::class, 'details_purchase_id');
    }
}

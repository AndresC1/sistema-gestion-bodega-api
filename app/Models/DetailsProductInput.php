<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsProductInput extends Model
{
    use HasFactory;

    protected $fillable = [
        'details_purchase_id',
        'product_input_id',
        'quantity',
        'price',
        'total',
        'description',
        'organization_id'
    ];

    public function detailsPurchase()
    {
        return $this->belongsTo(DetailsPurchase::class, 'details_purchase_id');
    }

    public function productInput()
    {
        return $this->belongsTo(ProductInput::class, 'product_input_id');
    }
}

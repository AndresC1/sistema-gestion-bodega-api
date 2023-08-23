<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'product_input_id',
        'organization_id',
        'quantity',
        'price',
        'total',
        'cost_unit',
        'cost_total',
        'earning',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function productInput()
    {
        return $this->belongsTo(ProductInput::class, 'product_input_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}

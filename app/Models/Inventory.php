<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'organization_id',
        'type',
        'stock',
        'stock_min',
        'unit_of_measurement',
        'location',
        'date_last_modified',
        'lot_number',
        'note',
        'status',
        'total_value',
        'code',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function productInputs()
    {
        return $this->hasMany(ProductInput::class, 'inventory_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutputsProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'organization_id',
        'user_id',
        'date',
        'quantity',
        'price',
        'total',
        'observation'
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

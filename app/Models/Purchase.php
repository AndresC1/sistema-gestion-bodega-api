<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_bill',
        'organization_id',
        'provider_id',
        'user_id',
        'date',
        'total',
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detailsPurchase()
    {
        return $this->hasMany(DetailsPurchase::class);
    }

    public function productInputs()
    {
        return $this->hasMany(ProductInput::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}

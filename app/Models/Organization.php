<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "ruc",
        "address",
        "sector_id",
        "municipality_id",
        "city_id",
        "phone_main",
        "phone_secondary",
    ];

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'organization_id');
    }

    public function providers()
    {
        return $this->hasMany(Provider::class, 'organization_id');
    }

    public function clients()
    {
        return $this->hasMany(Client::class, 'organization_id');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'organization_id');
    }

    public function productInputs()
    {
        return $this->hasMany(ProductInput::class, 'organization_id');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'organization_id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'organization_id');
    }

    public function detailsSales()
    {
        return $this->hasMany(DetailsSale::class, 'organization_id');
    }

    public function detailsPurchases()
    {
        return $this->hasMany(DetailsPurchase::class, 'organization_id');
    }

    public function ProductOutputs()
    {
        return $this->hasMany(OutputsProduct::class, 'organization_id');
    }
}

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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'organization_id',
        'type',
        'phone_main',
        'phone_secondary',
        'details',
        'status',
        'municipality_id',
        'city_id',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'client_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table='cities';

    protected $fillable=[
        'name',
    ];

    public function municipalities()
    {
        return $this->hasMany(Municipality::class, 'city_id');
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class, 'city_id');
    }
}

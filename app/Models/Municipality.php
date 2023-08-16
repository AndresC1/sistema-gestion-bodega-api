<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'city_id',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class, 'municipality_id');
    }

    public function providers()
    {
        return $this->hasMany(Provider::class, 'municipality_id');
    }
}

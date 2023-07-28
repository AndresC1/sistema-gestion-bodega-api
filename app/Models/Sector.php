<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
    ];

    public function organizations()
    {
        return $this->hasMany(Organization::class, 'sector_id');
    }
}

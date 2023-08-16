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
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}

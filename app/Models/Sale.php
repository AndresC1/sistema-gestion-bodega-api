<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_bill',
        'organization_id',
        'client_id',
        'user_id',
        'date',
        'total',
        'earning_total',
        'note',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function detailsSale()
    {
        return $this->hasMany(DetailsSale::class, 'sale_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'disk',
        'size',
        'type',
        'deleted_at',
        'deleted_by',
        'created_at',
        'updated_at'
    ];

    public function deletedBy(){
        return $this->belongsTo(User::class, 'deleted_by');
    }
}

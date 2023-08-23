<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'role_id',
        'organization_id',
        'last_login_at',
        'status',
        'verification_password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function organization(){
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function purchases(){
        return $this->hasMany(Purchase::class, 'user_id');
    }

    public function productInputs(){
        return $this->hasMany(ProductInput::class, 'user_id');
    }

    public function sales(){
        return $this->hasMany(Sale::class, 'user_id');
    }

    public function productOutput(){
        return $this->hasMany(OutputsProduct::class, 'user_id');
    }
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'type',
        'status',
        'balans',
        'currer_balans',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function regions(){
        return $this->hasMany(Region::class);
    }

    public function paymarts(){
        return $this->hasMany(Paymart::class);
    }

    public function omborchiHistories(){
        return $this->hasMany(ScladHistory::class, 'omborchi_id');
    }

    public function userHistories(){
        return $this->hasMany(ScladHistory::class, 'user_id');
    }

    public function scladTarixes(){
        return $this->hasMany(ScladTarix::class, 'user_id', 'id');
    }

    public function operatorKlents(){
        return $this->hasMany(Klent::class, 'operator_id');
    }

    public function currerKlents(){
        return $this->hasMany(Klent::class, 'currer_id');
    }

}

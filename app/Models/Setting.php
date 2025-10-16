<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id',
        'water_price',
        'idish_price',
        'currer_price',
        'sclad_price',
        'operator_price',
    ];
}

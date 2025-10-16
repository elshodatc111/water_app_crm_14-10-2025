<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Klent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'order_count',
        'status',
        'start_data',
        'operator_id',
        'pedding_time',
        'currer_id',
        'end_time',
        'region_id',
    ];

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function currer()
    {
        return $this->belongsTo(User::class, 'currer_id');
    }

    public function comments()
    {
        return $this->hasMany(KlentComment::class, 'klent_id');
    }
}

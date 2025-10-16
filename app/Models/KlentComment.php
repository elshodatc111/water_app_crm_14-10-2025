<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class KlentComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'klent_id',
        'user_id',
        'comment',
    ];

    public function klent()
    {
        return $this->belongsTo(Klent::class, 'klent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

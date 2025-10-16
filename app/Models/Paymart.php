<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paymart extends Model{
    use HasFactory;
    protected $table = 'paymarts';
    protected $fillable = [
        'user_id',
        'summa',
        'type',
        'comment',
        'admin_id',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function admin(){
        return $this->belongsTo(User::class, 'admin_id');
    }
}
